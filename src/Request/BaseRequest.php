<?php

namespace App\Request;

abstract class BaseRequest
{
    public function fromArray(?array $requests): self
    {
        foreach ($requests as $key => $request) {
            $action = 'set'.ucfirst($key);
            if (!method_exists($this, $action) || empty($request)) {
                continue;
            }
            if (is_numeric($request)) {
                $request = (int) $request;
            }
            $this->{$action}($request);
        }

        return $this;
    }
}
