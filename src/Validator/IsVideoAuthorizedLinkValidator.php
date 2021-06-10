<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsVideoAuthorizedLinkValidator extends ConstraintValidator
{



    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\IsVideoAuthorizedLink */

        if (null === $value || '' === $value) {
            return;
        }

        if (preg_match("#^https://www\.youtube\.com/embed/#",$value)) {
            return;
        }
        if (preg_match("#^https://www.dailymotion.com/embed/video/#",$value)) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
