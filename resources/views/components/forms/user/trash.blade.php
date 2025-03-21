<form method="POST" class="vlx-form" action="{{ route('dashboard.user.delete') }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <label class="h4">Are you sure you want to delete your account?</label>
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="delete" class="btn btn--danger btn--small">
            <i class="vlx-icon vlx-icon--trash vlx-icon--small"></i>
            Delete
        </button>
    </div>

</form>
