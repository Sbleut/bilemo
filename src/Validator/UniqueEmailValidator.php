<?php

namespace App\Validator;

use App\Entity\Customer;
use App\Entity\Reseller;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class UniqueEmailValidator extends ConstraintValidator
{
    public function __construct(private Security $security)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        assert($constraint instanceof UniqueEmail);

        if (null === $value || '' === $value) {
            return;
        }

        $reseller = $this->security->getUser();
        if($reseller instanceof Reseller){
            $resellerList = $reseller->getCustomers();
        }
        $bEmail=false;
        foreach ($resellerList as $reseller) {
            if ($reseller->getEmail() === $value) {
                $bEmail = true;
            }
        }
        if($bEmail){
            $this->context->buildViolation($constraint->message)
            ->addViolation();
        }
        
    }
}
