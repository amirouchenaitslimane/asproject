<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 29/08/2018
 * Time: 1:22
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{

    private $encodeur;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encodeur = $passwordEncoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);



    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->encodeur->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
            $manager->persist($user);
            $this->addReference($username, $user);
        }
        $manager->flush();
    }

    /**
     * @return array
     * Liste des utilisateur (Fausse liste :) )
     */
    private function getUserData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            ['samir', 'samir', '0000', 'samir@gmail.com', ['ROLE_ADMIN']],
            ['amirouche', 'amirouche', '0000', 'amirouche@gmail', ['ROLE_USER']],
              ];
    }
}