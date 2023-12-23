<h1>Coach Dashboard</h1>
<form id="logout-form" action="{{ route('coach.logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Click to logout
</a>

