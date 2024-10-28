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
    private $tempKeyPath;

    /**
     * setup the ssh connection to the server, only used within the Model
     */
    public function ssh()
    {

        $this->tempKeyPath = tempnam(sys_get_temp_dir(), 'ssh_key-');
        file_put_contents($this->tempKeyPath, $this->ssh_key);

        return Ssh::create($this->ssh_user, $this->address)
            ->usePrivateKey($this->tempKeyPath)
            ->disableStrictHostKeyChecking();
    }

    /**
     * Retrieve all users from the server
     * @param bool $filtered, filter out the default users that are setup with ubuntu
     * @return array
     */
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

    /**
     * Retrieve all ssh keys for a certain user on the server
     * @param string $username
     * @return array
     */
    public function getSSHKeys($username) {

        // Return if username is empty
        if (empty($username)) {
            return 'error:Username is required';
        }

        // Setup ssh connection to node
        $ssh = $this->ssh();

        try {
            // Check if user is root and use the correct path
            if ($username == 'root') {
                $process = $ssh->execute('sudo cat /' . $username . '/.ssh/authorized_keys');
            } else {
                $process = $ssh->execute('sudo cat /home/' . $username . '/.ssh/authorized_keys');
            }

            if ($process->isSuccessful()) {
                // Return an array of keys
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

    /**
     * Get the operating system of the server
     * @return string
     */
    public function getOS() {

        // Setup ssh connection to node
        $ssh = $this->ssh();

        try {
            $process = $ssh->execute('uname -a');

            if ($process->isSuccessful()) {
                $osOutput = strtolower($process->getOutput());

                // Return nice name based on the output
                if (str_contains($osOutput, 'ubuntu')) {
                    return 'ubuntu';
                } elseif (str_contains($osOutput, 'debian')) {
                    return 'debian';
                } elseif (str_contains($osOutput, 'fedora')) {
                    return 'fedora';
                } elseif (str_contains($osOutput, 'suse')) {
                    return 'suse';
                } elseif (str_contains($osOutput, 'redhat')) {
                    return 'redhat';
                } elseif (str_contains($osOutput, 'centos')) {
                    return 'centos';
                } else {
                    return $osOutput;
                }

            } else {
                return "error:".$process->getErrorOutput();
            }

        } catch (Exception $e) {
            return "error:".$e->getMessage();
        }
    }

    /**
     * Get the uptime of the server in a human readable format
     * @return string, Xd Xh Xm
     */
    public function uptime() {

        // Setup ssh connection to node
        $ssh = $this->ssh();

        try {
            $process = $ssh->execute('sudo uptime');

            if ($process->isSuccessful()) {
                // Parse the output of the uptime command
                return vlx_get_uptime($process->getOutput());
            } else {
                return "error:".$process->getErrorOutput();
            }

        } catch (Exception $e) {
            return "error:".$e->getMessage();
        }
    }

    /**
     * Make sure to remove the temp ssh key file on server deletion
     */
    public function __destruct()
    {
        if ($this->tempKeyPath && file_exists($this->tempKeyPath)) {
            unlink($this->tempKeyPath);
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
