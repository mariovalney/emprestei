<?php

namespace App\Support\Traits;

trait HasMessages
{
    /**
     * Messages
     *
     * @var  array
     */
    private static $messages = [];

    /**
     * Retrieve all messages
     * @return [type] [description]
     */
    public function messages($empty = true)
    {
        $messages = $this::$messages;

        if ($empty) {
            $this::$messages = [];
        }

        return $messages;
    }

    /**
     * Add a success
     *
     * @param  string $message
     * @return void
     */
    public function success($message)
    {
        $this->addMessage($message, 'success');
    }

    /**
     * Add a error
     *
     * @param  string $message
     * @return void
     */
    public function error($message)
    {
        $this->addMessage($message, 'error');
    }

    /**
     * Add a info
     *
     * @param  string $message
     * @return void
     */
    public function info($message)
    {
        $this->addMessage($message, 'info');
    }

    /**
     * Add a message
     *
     * @param string $message
     * @param string $type
     * @return void
     */
    private function addMessage($message, $type)
    {
        if (empty($this::$messages[ $type ])) {
            $this::$messages[ $type ] = [];
        }

        $this::$messages[ $type ][] = $message;
    }
}
