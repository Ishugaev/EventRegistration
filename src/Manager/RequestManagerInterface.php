<?php

namespace EventRegistration\Manager;

interface RequestManagerInterface
{
    /**
     * This method should take responsibility of management complicated controller logic with some sort of dependencies
     * @param array $requestData
     * @return mixed
     */
    public function manage(array $requestData);
}
