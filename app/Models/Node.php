<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Ssh\Ssh;
use Exception;

// Node as like a server node
class Node extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'name',
        'ssh_user',
        'ssh_key',
    ];

    protected $default_users = [ 'daemon', 'bin', 'sys', 'sync', 'games', 'man', 'lp', 'mail', 'news', 'uucp', 'proxy', 'www-data', 'backup', 'list', 'irc', 'gnats', 'nobody', 'systemd-network', 'systemd-resolve', 'messagebus', 'systemd-timesync', 'syslog', '_apt', 'tss', 'uuidd', 'tcpdump', 'sshd', 'pollinate', 'landscape', 'fwupd-refresh', 'lxd', 'mysql', 'pterodactyl', ];

    public function ssh()
    {
        return Ssh::create($this->ssh_user, $this->address)
            ->usePrivateKey(base_path(vlx_get_env_string('SSH_KEY_PATH') . $this->ssh_key))
            ->disableStrictHostKeyChecking();
    }

    public function getAllUsers($filtered = true) {

        $ssh = $this->ssh();

        try {
            $process = $ssh->execute('cut -d: -f1 /etc/passwd');

            if ($process->isSuccessful()) {
                $users = explode("\n", $process->getOutput());

                $filteredUsers = array_filter($users, function($user) {
                    return !in_array($user, $this->default_users);
                });

                return $filtered ? $filteredUsers : $users;
            } else {
                return "error:".$process->getErrorOutput();
            }

        } catch (Exception $e) {
            return "error:".$e->getMessage();
        }

    }

    public function getSshKeys($username) {

        if (empty($username)) {
            return 'error:Username is required';
        }

        $ssh = $this->ssh();

        try {
            if ($username == 'root') {
                $process = $ssh->execute('sudo cat /' . $username . '/.ssh/authorized_keys');
            } else {
                $process = $ssh->execute('sudo cat /home/' . $username . '/.ssh/authorized_keys');
            }

            if ($process->isSuccessful()) {
                return array_filter(explode("\n", $process->getOutput()), function($line) {
                    return !empty($line);
                });
            } else {
                return "error:".$process->getErrorOutput();
            }

        } catch (Exception $e) {
            return "error:".$e->getMessage();
        }
    }

    public function status() {

        $ssh = $this->ssh();

        try {
            $process = $ssh->execute('echo "Server is online"');

            if ($process->isSuccessful()) {
                return "Server is online";
            } else {
                return "Server is offline: " . $process->getErrorOutput();
            }

        } catch (Exception $e) {
            return "error:".$e->getMessage();
        }
    }




    /* use Spatie\Ssh\Ssh;
    $ssh = Ssh::create('servermanager', 'oliver.vacso.cloud')
        ->usePrivateKey(base_path('resources/assets/keys/openssh-oliver'))
        ->disableStrictHostKeyChecking();
    $outputs = [];

    try {
        $process = $ssh->execute('whoami');
        $outputs[] = $process->isSuccessful() ? $process->getOutput() : $process->getErrorOutput();
    } catch (Exception $e) {
        $outputs[] = "Error: " . $e->getMessage();
    }

    try {
        $process = $ssh->execute('sudo cat /home/blacksparow/.ssh/authorized_keys');
        $outputs[] = $process->isSuccessful() ? $process->getOutput() : $process->getErrorOutput();
    } catch (Exception $e) {
        $outputs[] = "Error: " . $e->getMessage();
    }

    try {
        $process = $ssh->execute('cat /home/servermanager/.ssh/authorized_keys');
        $outputs[] = $process->isSuccessful() ? $process->getOutput() : $process->getErrorOutput();
    } catch (Exception $e) {
        $outputs[] = "Error: " . $e->getMessage();
    } */
}
