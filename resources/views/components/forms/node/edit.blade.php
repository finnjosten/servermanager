<form method="POST" class="form" action="{{ route('dashboard.node.update') }}">
    @csrf

    <div class="form__box">
        <div class="col">
            <h3>Name</h3>
            <input required type="text" name="name" value="{{ $node->name }}" placeholder="The name of the node">
        </div>
        <div class="col">
            <h3>Address</h3>
            <input required type="text" name="address" value="{{ $node->address }}" placeholder="IPv4, IPv6 or FQDN">
        </div>
    </div>
    <div class="form__box">
        <div class="col">
            <h3>SSH User</h3>
            <input required type="text" name="ssh_user" value="{{ $node->ssh_user }}" placeholder="The username of the ssh user">
        </div>
        <div class="col">
            <h3>SSH Key</h3>
            <textarea required name="ssh_key" placeholder="The contents of the OpenSSH Key used to login to the node">Blank for safety, dont remove or edit if the key doesnt need to change</textarea>
        </div>
    </div>
    <div class="form__box">
        <button type="submit" name="add" class="btn btn--success btn--small">Update<i class="vlx-icon vlx-icon--floppy-disk vlx-icon--small"></i></button>
    </div>

</form>
