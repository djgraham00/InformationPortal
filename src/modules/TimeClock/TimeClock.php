<?php

class TimeClock extends MPModule {

    public $rts = [
                    "/TimeClock"    => [
                        "path"      => "/TimeClock",
                        "component" => "TimeClock"
                    ]
    ];

    protected function init() {

        $AdminPanel = $this->Parent->Modules['_AdminPanel'];
        $AdminPanel->registerPage("Time Clock", "./TimeClock");

    }

    public function __initModels () {

    }

}