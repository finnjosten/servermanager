<form method="POST" class="form" action="{{ route('dashboard.node.store') }}">
    @csrf

    <div class="form__box">
        <div class="col">
            <h3>Name</h3>
            <input required type="text" name="name" placeholder="The name of the node">
        </div>
        <div class="col">
            <h3>Address</h3>
            <input required type="text" name="address" placeholder="IPv4, IPv6 or FQDN">
        </div>
    </div>
    <div class="form__box">
        <div class="col">
            <h3>SSH User</h3>
            <input required type="text" name="ssh_user" placeholder="The username of the ssh user">
        </div>
        <div class="col">
            <h3>SSH Key</h3>
            <textarea required name="ssh_key" placeholder="The contents of the OpenSSH Key used to login to the node"></textarea>
        </div>
    </div>
    <div class="form__box">
        <button type="submit" name="add" class="btn btn--success btn--small">Save<i class="vlx-icon vlx-icon--floppy-disk vlx-icon--small"></i></button>
    </div>

</form>
