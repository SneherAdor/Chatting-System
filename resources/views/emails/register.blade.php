<!DOCTYPE html>
<html>
<title>New User Registration</title>
<body>
<div class="card">
    <img src="{{ url('storage/users/'.$user->photo) }}" style="width:100%" alt="">
  <br>
  <h2><b>New User Registration</b></h2>
  <hr>
  <h3><b>Name: {{$user->name}}</b></h3>
  <p>Email: {{$user->email}}</p>
  <p>Status: {{$user->status}}</p>
  <p>Registered: {{$user->created_at}}</p>
  <p><a href="{{ url('/users/profile/').'/'.$user->id }}" class="button" target="_blank">View Profile</a></p>
</div>
</body>
</html>
