<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Project;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
  
    public function show($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        
        // Check if invitation is expired
        if ($invitation->isExpired()) {
            return view('invitations.expired', compact('invitation'));
        }
        
        // Check if invitation is already accepted or declined
        if ($invitation->status !== 'pending') {
            return view('invitations.processed', compact('invitation'));
        }
        
        // Check if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            
            // If invitation was for a different email, show error
            if ($user->email !== $invitation->email) {
                return view('invitations.wrong-user', [
                    'invitation' => $invitation,
                    'currentEmail' => $user->email
                ]);
            }
            
            // Show accept/decline page for logged in user
            return view('invitations.show', compact('invitation'));
        }
        
        // For users who aren't logged in
        // First check if a user with this email already exists
        $existingUser = User::where('email', $invitation->email)->first();
        
        if ($existingUser) {
            // User exists but isn't logged in
            return view('invitations.login', compact('invitation'));
        } else {
            // User doesn't exist yet
            return view('invitations.register', compact('invitation'));
        }
    }
    
   
    public function accept(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        
        // Check if invitation is expired or already processed
        if ($invitation->isExpired() || $invitation->status !== 'pending') {
            return redirect()->route('invitations.show', $token)
                ->with('error', 'This invitation cannot be accepted.');
        }
        
        // Get current user
        $user = Auth::user();
        
        // If user email doesn't match invitation email
        if ($user->email !== $invitation->email) {
            return redirect()->route('invitations.show', $token)
                ->with('error', 'This invitation was sent to a different email address.');
        }
        
        // Get the project
        $project = $invitation->project;
        
        // Check if user is already part of the project
        $existingRole = $project->users()
            ->wherePivot('user_id', $user->id)
            ->first();
            
        if ($existingRole) {
            // User is already part of the project
            $invitation->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);
            
            return redirect()->route('projects.show', $project->id)
                ->with('message', 'You are already a member of this project.');
        }
        
        // Add user to project with the specified role
        $project->users()->attach($user->id, ['role' => $invitation->role]);
        
        // Update invitation status
        $invitation->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);
        
        // Record in activity log
        $user->activities()->create([
            'name' => ucfirst($invitation->role) . ' Joined',
            'description' => 'Joined project "' . $project->title . '" as ' . $invitation->role,
            'type' => 'project',
            'project_id' => $project->id,
            'issue_date' => now(),
        ]);
        
        // Notify the project supervisor
        $supervisor = $project->supervisor()->first();
        if ($supervisor) {
            NotificationService::sendToUser(
                $supervisor,
                'Invitation Accepted',
                $user->name . ' has accepted your invitation to join the project "' . $project->title . '" as a ' . $invitation->role . '.',
                'View Project',
                route('projects.show', $project->id),
                'success'
            );
        }
        
        return redirect()->route('projects.show', $project->id)
            ->with('message', 'You have successfully joined the project as a ' . $invitation->role . '.');
    }
    
  
    public function decline(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        
        // Check if invitation is expired or already processed
        if ($invitation->isExpired() || $invitation->status !== 'pending') {
            return redirect()->route('invitations.show', $token)
                ->with('error', 'This invitation cannot be declined.');
        }
        
        // Update invitation status
        $invitation->update([
            'status' => 'declined',
            'declined_at' => now(),
        ]);
        
        // Notify the person who sent the invitation
        $inviter = $invitation->inviter;
        NotificationService::sendToUser(
            $inviter,
            'Invitation Declined',
            $invitation->email . ' has declined your invitation to join the project "' . $invitation->project->title . '".',
            'View Project',
            route('projects.show', $invitation->project_id),
            'warning'
        );
        
        return redirect()->route('dashboard')
            ->with('message', 'You have declined the invitation.');
    }
    
  
    public function registerAndAccept(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        
        // Check if invitation is expired or already processed
        if ($invitation->isExpired() || $invitation->status !== 'pending') {
            return redirect()->route('invitations.show', $token)
                ->with('error', 'This invitation cannot be accepted.');
        }
        
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('invitations.show', $token)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Check if email is already in use
        $existingUser = User::where('email', $invitation->email)->first();
        if ($existingUser) {
            return redirect()->route('invitations.show', $token)
                ->with('error', 'An account with this email already exists. Please log in instead.');
        }
        
        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Default user role - adjust according to your system
        ]);
        
        // Log in the new user
        Auth::login($user);
        
        // Get the project
        $project = $invitation->project;
        
        // Add user to project with the specified role
        $project->users()->attach($user->id, ['role' => $invitation->role]);
        
        // Update invitation status
        $invitation->update([
            'status' => 'accepted',
            'accepted_at' => now(),
            'user_id' => $user->id,
        ]);
        
        // Record in activity log
        $user->activities()->create([
            'name' => ucfirst($invitation->role) . ' Joined',
            'description' => 'Joined project "' . $project->title . '" as ' . $invitation->role,
            'type' => 'project',
            'project_id' => $project->id,
            'issue_date' => now(),
        ]);
        
        // Notify the project supervisor
        $supervisor = $project->supervisor()->first();
        if ($supervisor) {
            NotificationService::sendToUser(
                $supervisor,
                'Invitation Accepted',
                $user->name . ' has registered and accepted your invitation to join the project "' . $project->title . '" as a ' . $invitation->role . '.',
                'View Project',
                route('projects.show', $project->id),
                'success'
            );
        }
        
        return redirect()->route('projects.show', $project->id)
            ->with('message', 'Your account has been created and you have joined the project as a ' . $invitation->role . '.');
    }
}