@component('mail::message')
# Hello From FastShare
<p class="lead">
    Thank <strong>{{auth()->user()->name}}</strong> so much for subscribing to our fast file sharing system.
    Hope that you enjoy with our system!
</p>
<hr>
<p>
    If you need any help please contact our admin.
</p>
Thanks, {{ config('app.name') }} Team
<div class="footer">
    <p class="text-footer">Admin Nguyen Trong Nghia - 0911551998</p>
</div>
@endcomponent
