<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\ProjectNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send notification to a user
     *
     * @param User $user
     * @param string $subject
     * @param string $body
     * @param string $actionText
     * @param string $actionURL
     * @param string $type
     * @return void
     */
    public static function sendToUser(User $user, string $subject, string $body, string $actionText, string $actionURL, string $type = 'info')
    {
        $user->notify(new ProjectNotification([
            'id' => uniqid(),
            'subject' => $subject,
            'greeting' => 'Hello ' . $user->name . '!',
            'body' => $body,
            'actionText' => $actionText,
            'actionURL' => $actionURL,
            'thanks' => 'Thank you for using our application!',
            'type' => $type,
        ]));
    }

    /**
     * Send notification to multiple users
     *
     * @param array $users
     * @param string $subject
     * @param string $body
     * @param string $actionText
     * @param string $actionURL
     * @param string $type
     * @return void
     */
    public static function sendToMultipleUsers(array $users, string $subject, string $body, string $actionText, string $actionURL, string $type = 'info')
    {
        $notificationData = [
            'id' => uniqid(),
            'subject' => $subject,
            'body' => $body,
            'actionText' => $actionText,
            'actionURL' => $actionURL,
            'thanks' => 'Thank you for using our application!',
            'type' => $type,
        ];

        foreach ($users as $user) {
            $notificationData['greeting'] = 'Hello ' . $user->name . '!';
            $user->notify(new ProjectNotification($notificationData));
        }
    }

    /**
     * Send notification to project members
     *
     * @param \App\Models\Project $project
     * @param string $subject
     * @param string $body
     * @param string $actionText
     * @param string $actionURL
     * @param string $type
     * @param array $exceptUsers
     * @return void
     */
    public static function sendToProjectMembers($project, string $subject, string $body, string $actionText, string $actionURL, string $type = 'info', array $exceptUsers = [])
    {
        $members = $project->users()->whereNotIn('users.id', $exceptUsers)->get();
        
        $notificationData = [
            'id' => uniqid(),
            'subject' => $subject,
            'body' => $body,
            'actionText' => $actionText,
            'actionURL' => $actionURL,
            'thanks' => 'Thank you for using our application!',
            'type' => $type,
        ];

        foreach ($members as $member) {
            $notificationData['greeting'] = 'Hello ' . $member->name . '!';
            $member->notify(new ProjectNotification($notificationData));
        }
    }

    /**
     * Send notification to project supervisor
     *
     * @param \App\Models\Project $project
     * @param string $subject
     * @param string $body
     * @param string $actionText
     * @param string $actionURL
     * @param string $type
     * @return void
     */
    public static function sendToProjectSupervisor($project, string $subject, string $body, string $actionText, string $actionURL, string $type = 'info')
    {
        $supervisor = $project->supervisor()->first();
        
        if ($supervisor) {
            self::sendToUser($supervisor, $subject, $body, $actionText, $actionURL, $type);
        }
    }
}