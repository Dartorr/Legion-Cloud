<header>
    <div id="header_left">
        <div>
            @php
                use App\User;

                    session_start();
                    if (!isset($_SESSION['id'])){
                        $_SESSION['forcedLog']=true;
                        echo '<script>alert("Вы не залогинены"); location.href="'.url('/auth').'"</script>';
                        }
                        else {
                            $user=User::find($_SESSION['id']);
                            echo ($user->name.' <span>'.\App\Role::find($user->role)->roleName.'</span>');
                            $_SESSION['canInvite']=\App\Role::find($user->role)->canInvite;

                }
            @endphp
        </div>
    </div>
    <div id="logout">
        <input id="logout_button" type="button" value="ВЫЙТИ" onclick="location.href='{{url('auth')}}'">
    </div>
</header>
