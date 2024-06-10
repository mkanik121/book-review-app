    
    <ul class="nav flex-column">
         @if(Auth::user()->role == 'admin')
            <li class="nav-item">
                <a href="{{ route('books.list') }}">Books</a>                               
            </li>
            <li class="nav-item">
                <a href="{{ route('list.review') }}">Reviews</a>                               
            </li>
          @endif        
            <li class="nav-item">
                <a href="{{ route('account.profile') }}">Profile</a>                               
            </li>
            <li class="nav-item">
                <a href="{{ route('account.myReviews') }}">My Reviews</a>
            </li>
            <li class="nav-item">
                <a href="change-password.html">Change Password</a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('account.logout') }}">Logout</a>
            </li>                           
        </ul>