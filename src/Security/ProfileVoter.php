<?php

// src/Security/ProfileVoter.php
namespace App\Security;

use App\Entity\Person;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Doctrine\ORM\EntityManagerInterface;

class ProfileVoter extends Voter
{
// these strings are just invented: you can use anything

const EDIT = 'edit';

protected function supports($attribute, $subject): bool
{

    // if the attribute isn't one we support, return false
    if (!in_array($attribute, [self::EDIT])) {
        return false;

    }

    // only vote on `Person` objects
    if (!$subject instanceof Person) {
        return false;
    }

    return true;
}

protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
{
    $user = $token->getUser();

    if (!$user instanceof User) {

        // the user must be logged in; if not, deny access
        return false;
    }

    // you know $subject is a Person object, thanks to `supports()`

    $person = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($person, $user);
    }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Person $person, User $user): bool
    {
        //Check if logged in user and profile is the same.
        if ($user === $person->getUser()) {
            return $user === $person->getUser();
        }

        //Check if logged in user and profile is a child.
        else if ($person->getParents()) {

            $parents = $person->getParents();

            foreach ($parents as $parents) {

                if ($parents === $user->getPerson()){
                    return true;
                }
            }

        }
        return false;
    }

}