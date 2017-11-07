<?php
namespace UrlBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UrlFormatValidator
 *
 * @package UrlBundle\Validator\Constraints
 */
class UrlFormatValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        $regex = "/^((https?):\/\/)?(([^@]+)?(@?([^:]+):))?([^:\/$]+)(:?(\d+)($)?)?([^?$]+)?(\?([^#$]+))?(#([^$]+))?$/";
        if (!preg_match($regex, $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}