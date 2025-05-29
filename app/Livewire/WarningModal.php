<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class WarningModal extends Component
{
    public bool $show = false;
    public string $title;
    public string $body;
    public string|null $callBackFunction;
    public $callBackFunctionParameter;

    public function render()
    {
        return view('livewire.warning-modal');
    }

    public function confirm() {
        $this->dispatch($this->callBackFunction, $this->callBackFunctionParameter);
        $this->show = false;
    }

    #[On('openWarningModal')]
    public function openModal($data)
    {
        $this->title = $data['title'] ?? 'Warning';
        $this->body = $data['body'] ?? '';
        $this->callBackFunction = $data['callBackFunction'] ?? null;
        $this->callBackFunctionParameter = $data['callBackFunctionParameter'] ?? null;
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }
}
