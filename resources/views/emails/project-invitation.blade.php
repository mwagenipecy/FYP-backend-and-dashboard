@component('mail::message')
# You've Been Invited to Join a Project

{{ $invitation->inviter->name }} has invited you to join the project "**{{ $invitation->project->title }}**" as a **{{ ucfirst($invitation->role) }}**.

@if($invitation->message)
## Message from {{ $invitation->inviter->name }}:

"{{ $invitation->message }}"
@endif

@component('mail::panel')
This invitation will expire on {{ $expiresAt }}.
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'primary'])
View Invitation
@endcomponent

If you don't already have an account, you'll be able to create one when you accept the invitation.

Thanks,<br>
{{ config('app.name') }}
@endcomponent