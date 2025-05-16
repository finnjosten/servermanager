<?php

namespace App\Livewire\Modals;

use App\Models\Node;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Webserver extends Component
{
    public $showModal = false;
    public $loading = true;
    public $id;
    public Node $node;

    public $btns_loading = [
        'save' => false,
        'delete' => false,
        'disable' => false,
        'enable' => false,
        'certbot' => false,
    ];
    public $btns_disabled = [
        'save' => false,
        'delete' => false,
        'disable' => false,
        'enable' => false,
        'certbot' => false,
    ];


    public $root = '';
    public $proxy = '';
    public $ports = '';
    public $server_name = '';
    public $ssl = '';
    public $cert = '';
    public $key = '';
    public $content = '';

    #[On('show-webserver-modal')]
    public function show($id) {
        if (!Auth::user()->id == $this->node->user_id) {
            $this->js('toastError("You are not allowed to edit this webserver")');
            $this->hide();
            return;
        }

        $this->showModal = true;
        $this->loading = true;
        $this->id = $id;

        // Dispatch browser event to load data after modal is shown
        $this->dispatch('load-webserver-data');
    }

    #[On('hide-webserver-modal')]
    public function hide() {
        $this->showModal = false;

        // Reset previous data
        $this->root = '';
        $this->proxy = '';
        $this->ports = '';
        $this->server_name = '';
        $this->ssl = '';
        $this->cert = '';
        $this->key = '';
        $this->content = '';
    }

    public function save() {

        if (!Auth::user()->id == $this->node->user_id) {
            $this->js('toastError("You are not allowed to edit this webserver")');
            $this->hide();
            return;
        }

        $this->setLoadingBtn('save');

        // Dispatch browser event to save data
        $this->dispatch('save-webserver-data');
    }

    public function disable() {

        if (!Auth::user()->id == $this->node->user_id) {
            $this->js('toastError("You are not allowed to edit this webserver")');
            $this->hide();
            return;
        }

        $this->setLoadingBtn('disable');

        // Dispatch browser event to disable webserver
        $this->dispatch('disable-webserver-data');
    }

    public function enable() {

        if (!Auth::user()->id == $this->node->user_id) {
            $this->js('toastError("You are not allowed to edit this webserver")');
            $this->hide();
            return;
        }

        $this->setLoadingBtn('enable');

        // Dispatch browser event to enable webserver
        $this->dispatch('enable-webserver-data');
    }

    public function certbot() {

        if (!Auth::user()->id == $this->node->user_id) {
            $this->js('toastError("You are not allowed to edit this webserver")');
            $this->hide();
            return;
        }

        $this->setLoadingBtn('certbot');

        // Dispatch browser event to certbot webserver
        $this->dispatch('certbot-webserver-data');
    }

    public function delete() {

        if (!Auth::user()->id == $this->node->user_id) {
            $this->js('toastError("You are not allowed to edit this webserver")');
            $this->hide();
            return;
        }

        $this->setLoadingBtn('delete');

        // Dispatch browser event to delete webserver
        $this->dispatch('delete-webserver-data');
    }



    /**
     * Helper: Set loading state for buttons
     * Will set the loading state for the button and disable all other buttons
     * @param string $btn
     */
    private function setLoadingBtn($btn) {
        foreach ($this->btns_loading as $key => $value) {
            if ($key != $btn) {
                $this->btns_loading[$key] = false;
            } else {
                $this->btns_loading[$key] = true;
            }
        }

        foreach ($this->btns_disabled as $key => $value) {
            if ($key != $btn) {
                $this->btns_disabled[$key] = true;
            } else {
                $this->btns_disabled[$key] = false;
            }
        }
    }

    /**
     * Helper: Reset loading state for buttons
     * Will set the loading & disabled state for all buttons to false
     */
    private function resetBtns() {
        foreach ($this->btns_loading as $key => $value) {
            $this->btns_loading[$key] = false;
        }

        foreach ($this->btns_disabled as $key => $value) {
            $this->btns_disabled[$key] = false;
        }
    }












    /**
     * Load the data into the modal
     */
    #[On('load-webserver-data')]
    public function loadData() {
        $results = vlx_cast_to_object($this->node->get_webserver_config($this->id));

        $this->loading = false;

        if ($results->status == 'error') {
            session()->flash('error', $results->message);
            $this->hide();
            $this->resetBtns();
            $this->redirect(request()->header('Referer'));
        }

        if ($results->status == 'success') {
            $this->root = $results->data->root;
            $this->proxy = $results->data->proxy;
            $this->ports = implode(', ', vlx_cast_to_array($results->data->ports));
            $this->server_name = $results->data->server_name;
            $this->ssl = $results->data->ssl->enabled ? 'true' : 'false';
            $this->cert = $results->data->ssl->cert;
            $this->key = $results->data->ssl->key;
            $this->content = $results->data->content;
        }

        if ($results->status == 'warning') {
            $this->js("toastWarning('{$results->warning}')");
        }

        $this->resetBtns();
    }

    /**
     * Save the data from the modal
     */
    #[On('save-webserver-data')]
    public function saveData() {
        $results = vlx_cast_to_object($this->node->save_webserver_config($this->id, [
            'root' => $this->root,
            'proxy' => $this->proxy,
            'ports' => explode(',', $this->ports),
            'server_name' => $this->server_name,
            'ssl' => $this->ssl,
            'cert' => $this->cert,
            'key' => $this->key,
            'content' => $this->content,
        ]));

        if ($results->status == 'error') {
            $this->js("toastError('{$results->message}')");
            return;
        }
        if ($results->status == 'warning') {
            session()->flash('warning', $results->warning);
        }
        if ($results->status == 'success') {
            session()->flash('success', 'Config successfully updated');
        }

        $this->hide();
        $this->resetBtns();
        $this->redirect(request()->header('Referer'));
    }

    /**
     * Disable the webserver
     */
    #[On('disable-webserver-data')]
    public function disableData() {
        $results = vlx_cast_to_object($this->node->disable_webserver_config($this->id));

        if ($results->status == 'error') {
            $this->js("toastError('{$results->message}')");
            return;
        }
        if ($results->status == 'warning') {
            session()->flash('warning', $results->warning);
        }
        if ($results->status == 'success') {
            session()->flash('success', 'Webserver successfully disabled');
        }

        $this->hide();
        $this->resetBtns();
        $this->redirect(request()->header('Referer'));
    }

    /**
     * Enable the webserver
     */
    #[On('enable-webserver-data')]
    public function enableData() {
        $results = vlx_cast_to_object($this->node->enable_webserver_config($this->id));

        if ($results->status == 'error') {
            $this->js("toastError('{$results->message}')");
            return;
        }
        if ($results->status == 'warning') {
            session()->flash('warning', $results->warning);
        }
        if ($results->status == 'success') {
            session()->flash('success', 'Webserver successfully enabled');
        }

        $this->hide();
        $this->resetBtns();
        $this->redirect(request()->header('Referer'));
    }

    /**
     * Certbot the webserver
     */
    #[On('certbot-webserver-data')]
    public function certbotData() {
        $results = vlx_cast_to_object($this->node->certbot_webserver_config($this->id));

        if ($results->status == 'error') {
            $this->js("toastError('{$results->message}')");
            return;
        }
        if ($results->status == 'warning') {
            session()->flash('warning', $results->warning);
        }
        if ($results->status == 'success') {
            session()->flash('success', 'Certbot successfully run');
        }

        $this->hide();
        $this->resetBtns();
        $this->redirect(request()->header('Referer'));
    }

    /**
     * Delete the webserver
     */
    #[On('delete-webserver-data')]
    public function deleteData() {
        $results = vlx_cast_to_object($this->node->remove_webserver_config($this->id));

        if ($results->status == 'error') {
            $this->js("toastError('{$results->message}')");
            return;
        }
        if ($results->status == 'warning') {
            session()->flash('warning', $results->warning);
        }
        if ($results->status == 'success') {
            session()->flash('success', 'Webserver successfully deleted');
        }

        $this->hide();
        $this->resetBtns();
        $this->redirect(request()->header('Referer'));
    }


}
