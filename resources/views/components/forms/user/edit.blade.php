<form method="POST" class="vlx-form" action="{{ route('profile.update') }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <div class="vlx-input-box">
            <label class="h4">Name</label>
            <input required name="name" value="{{$user->name }}">
        </div>
        <div class="vlx-input-box">
            <label class="h4">Email</label>
            <input required name="email" value="{{$user->email }}">
        </div>
    </div>

    <div class="vlx-form__box">
        <div class="vlx-input-box">
            <label class="h4">Datalix Token</label>
            <input required name="datalix_token" value="{{ vlxIsEncrypted($user->datalix_token) ? Crypt::decrypt($user->datalix_token) : $user->datalix_token }}">
        </div>
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <div class="vlx-input-box">
            <label class="h4">Current password</label>
            <input class="js-password" type="password" name="cur_password" id="password">
            <i class="vlx-icon vlx-icon--eye js-password-btn"></i>
        </div>
        <div class="vlx-input-box">
            <label class="h4">New password</label>
            <input class="js-password" type="password" name="new_password" id="password">
            <i class="vlx-icon vlx-icon--eye js-password-btn"></i>
        </div>
    </div>


    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <i class="vlx-icon vlx-icon--floppy-disk vlx-icon--small"></i>
            Update
        </button>
    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInputs = document.querySelectorAll('.js-password');
        const passwordBtns = document.querySelectorAll('.js-password-btn');

        passwordBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                if (passwordInputs[index].type === 'password') {
                    passwordInputs[index].type = 'text';
                    btn.classList.remove('vlx-icon--eye');
                    btn.classList.add('vlx-icon--eye-slash');
                } else {
                    passwordInputs[index].type = 'password';
                    btn.classList.add('vlx-icon--eye');
                    btn.classList.remove('vlx-icon--eye-slash');
                }
            });
        });
    });
</script>
