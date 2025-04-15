<h2>Halo, {{ Auth::user()->name }}</h2>
<p>Role: {{ Auth::user()->role }}</p>

<form  action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
