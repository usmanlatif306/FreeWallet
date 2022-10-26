<div class="col-md-3">
    <div class="list-group">
        <a href="{{url('/')}}"  class="list-group-item list-group-item-action {{ (Route::is('home') ? 'active' : '') }}">{{__('Home')}}</a>
        <a href="{{url('/')}}/{{app()->getLocale()}}/profile/info"  class="list-group-item list-group-item-action {{ (Route::is('profile.info') ? 'active' : '') }}">{{__('Personal Info')}}</a>
        <a href="{{ route('profile.identity', app()->getLocale()) }}" class="list-group-item list-group-item-action {{ (Route::is('profile.identity') ? 'active' : '') }}">{{__('Proof of Identity')}}</a>
        <a href="{{ route('profile.newpassword', app()->getLocale()) }}" class="list-group-item list-group-item-action {{ (Route::is('profile.newpassword') ? 'active' : '') }}">{{__('Change Password')}}</a>
    </div>
</div>