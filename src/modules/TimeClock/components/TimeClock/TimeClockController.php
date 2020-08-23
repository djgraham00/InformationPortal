<?php

class TimeClockController extends MPComponent {

    public function __GET($params)
    {
        $this->template = "TimeClock.twig";
        $this->__render();
    }

}