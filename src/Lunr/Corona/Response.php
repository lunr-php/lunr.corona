<?php

/**
 * This file contains the response abstraction class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

/**
 * Response abstraction class.
 * Transport of data between Model/Controller and View
 */
class Response
{

    /**
     * Data store
     * @var array<string, array<array-key, mixed>|object|scalar|null>
     */
    private array $data;

    /**
     * Result code
     * @var array<string, int>
     */
    private array $resultCode;

    /**
     * Result message
     * @var array<string, string>
     */
    private array $resultMessage;

    /**
     * Additional result info
     * @var array<string, int>
     */
    private array $resultInfoCode;

    /**
     * The selected view to display the data.
     * @var string
     */
    private string $view;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data           = [];
        $this->resultMessage  = [];
        $this->resultCode     = [];
        $this->resultInfoCode = [];
        $this->view           = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->data);
        unset($this->resultMessage);
        unset($this->resultCode);
        unset($this->resultInfoCode);
        unset($this->view);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to the error information and the return code.
     *
     * @param string $name Attribute name
     *
     * @return string|null $return Value of the chosen attribute
     */
    public function __get(string $name): ?string
    {
        switch ($name)
        {
            case 'view':
                return $this->$name;
            default:
                return NULL;
        }
    }

    /**
     * Set values for return code and error information.
     *
     * @param string $name  Attribute name
     * @param string $value Attribute value to set
     *
     * @return void
     */
    public function __set(string $name, string $value): void
    {
        switch ($name)
        {
            case 'view':
                $this->$name = $value;
                return;
            default:
                return;
        }
    }

    /**
     * Add response data for later processing by a view.
     *
     * @deprecated Use addResponseData() instead
     *
     * @param string                                     $key   Identifier for the data
     * @param array<array-key, mixed>|object|scalar|null $value The data
     *
     * @return void
     */
    public function add_response_data(string $key, array|object|bool|float|int|string|null $value): void
    {
        $this->addResponseData($key, $value);
    }

    /**
     * Add response data for later processing by a view.
     *
     * @param string                                     $key  Identifier for the data
     * @param array<array-key, mixed>|object|scalar|null $data The data
     *
     * @return void
     */
    public function addResponseData(string $key, array|object|bool|float|int|string|null $data): void
    {
        $this->data[$key] = $data;
    }

    /**
     * Set an error message for the given call identifier.
     *
     * @deprecated Use setResultMessage() instead
     *
     * @param string $identifier Call identifier
     * @param string $value      Error message
     *
     * @return void
     */
    public function set_error_message(string $identifier, string $value): void
    {
        $this->setResultMessage($identifier, $value);
    }

    /**
     * Set a result message for the given call identifier.
     *
     * @param string $identifier Call identifier
     * @param string $message    Result message
     *
     * @return void
     */
    public function setResultMessage(string $identifier, string $message): void
    {
        $this->resultMessage[$identifier] = $message;
    }

    /**
     * Set additional error information for the given call identifier.
     *
     * @deprecated Use setResultInfoCode() instead
     *
     * @param string $identifier Call identifier
     * @param int    $value      Additional error information
     *
     * @return void
     */
    public function set_error_info(string $identifier, int $value): void
    {
        $this->setResultInfoCode($identifier, $value);
    }

    /**
     * Set additional result information code for the given call identifier.
     *
     * @param string $identifier Call identifier
     * @param int    $infoCode   Additional result information code
     *
     * @return void
     */
    public function setResultInfoCode(string $identifier, int $infoCode): void
    {
        $this->resultInfoCode[$identifier] = $infoCode;
    }

    /**
     * Set a return code for the given call identifier.
     *
     * @deprecated Use setResultCode() instead
     *
     * @param string $identifier Call identifier
     * @param int    $value      Return code
     *
     * @return void
     */
    public function set_return_code(string $identifier, int $value): void
    {
        $this->setResultCode($identifier, $value);
    }

    /**
     * Set a result code for the given call identifier.
     *
     * @param string $identifier Call identifier
     * @param int    $code       Result code
     *
     * @return void
     */
    public function setResultCode(string $identifier, int $code): void
    {
        $this->resultCode[$identifier] = $code;
    }

    /**
     * Get a specific response data.
     *
     * @deprecated Use getResponseData() instead
     *
     * @param string|null $key Identifier for the data
     *
     * @return array<array-key, mixed>|object|scalar|null The matching data on success, or NULL on failure
     */
    public function get_response_data(?string $key = NULL): array|object|bool|float|int|string|null
    {
        return $this->getResponseData($key);
    }

    /**
     * Get a specific response data.
     *
     * @param string|null $key Identifier for the data
     *
     * @return array<array-key, mixed>|object|scalar|null The matching data on success, or NULL on failure
     */
    public function getResponseData(?string $key = NULL): array|object|bool|float|int|string|null
    {
        if ($key === NULL)
        {
            return $this->data;
        }

        return isset($this->data[$key]) ? $this->data[$key] : NULL;
    }

    /**
     * Get error message for a call identifier.
     *
     * @deprecated Use getResultMessage() instead
     *
     * @param string $identifier Call identifier
     *
     * @return string|null The matching error message on success, or NULL on failure
     */
    public function get_error_message(string $identifier): ?string
    {
        return $this->getResultMessage($identifier);
    }

    /**
     * Get error message for a call identifier.
     *
     * @param string $identifier Call identifier
     *
     * @return string|null The matching error message on success, or NULL on failure
     */
    public function getResultMessage(string $identifier): ?string
    {
        return isset($this->resultMessage[$identifier]) ? $this->resultMessage[$identifier] : NULL;
    }

    /**
     * Get error info for a call identifier.
     *
     * @deprecated Use getResultInfoCode() instead
     *
     * @param string $identifier Call identifier
     *
     * @return int|null The matching error info on success, or NULL on failure
     */
    public function get_error_info(string $identifier): ?int
    {
        return $this->getResultInfoCode($identifier);
    }

    /**
     * Get result info code for a call identifier.
     *
     * @param string $identifier Call identifier
     *
     * @return int|null The matching result info code on success, or NULL on failure
     */
    public function getResultInfoCode(string $identifier): ?int
    {
        return isset($this->resultInfoCode[$identifier]) ? $this->resultInfoCode[$identifier] : NULL;
    }

    /**
     * Get return code for most severe error, or for call identifier if given.
     *
     * @deprecated Use getResultCode() instead
     *
     * @param string|null $identifier Call identifier
     *
     * @return int|null The matching return code on success, or NULL on failure
     */
    public function get_return_code($identifier = NULL): ?int
    {
        return $this->getResultCode($identifier);
    }

    /**
     * Get result code for most severe error, or for call identifier if given.
     *
     * @param string|null $identifier Call identifier
     *
     * @return int|null The matching result code on success, or NULL on failure
     */
    public function getResultCode($identifier = NULL): ?int
    {
        if (empty($this->resultCode))
        {
            return NULL;
        }

        if ($identifier === NULL)
        {
            $identifier = array_search(max($this->resultCode), $this->resultCode);
        }

        return isset($this->resultCode[$identifier]) ? $this->resultCode[$identifier] : NULL;
    }

    /**
     * Get the set of return code identifiers.
     *
     * @deprecated Use getResultCodeIdentifiers() instead
     *
     * @param bool $max Only return the identifier of the highest error code (FALSE by default)
     *
     * @return string|string[] Requested set of identifiers.
     */
    public function get_return_code_identifiers(bool $max = FALSE): string|array
    {
        return $this->getResultCodeIdentifiers($max);
    }

    /**
     * Get the set of result code identifiers.
     *
     * @param bool $max Only return the identifier of the highest result code (FALSE by default)
     *
     * @return string|list<string> Requested set of identifiers.
     */
    public function getResultCodeIdentifiers(bool $max = FALSE): string|array
    {
        if (empty($this->resultCode))
        {
            return [];
        }

        if ($max === TRUE)
        {
            $maxIdentifier = array_key_first($this->resultCode);
            $maxCode       = $this->resultCode[$maxIdentifier];

            foreach ($this->resultCode as $identifier => $value)
            {
                if ($value > $maxCode)
                {
                    $maxIdentifier = $identifier;
                    $maxCode       = $maxCode;
                }
            }

            return $maxIdentifier;
        }
        else
        {
            return array_keys($this->resultCode);
        }
    }

}

?>
