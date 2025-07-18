<?php

namespace Playhub\Service;

use Symfony\Component\Validator\Validation;
use Playhub\Contract\SearchRequestInterface;

class ValidatorService
{
    static function validateSearchRequest(SearchRequestInterface $searchCardRequest): array
    {
        $errors = [];
        $violations = (Validation::createValidator())->validate($searchCardRequest);
        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
        }

        return $errors;
    }
}
