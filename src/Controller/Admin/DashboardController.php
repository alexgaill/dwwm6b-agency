<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Options;
use App\Entity\Property;
use App\Entity\Appointment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    // #[IsGranted("ROLE_USER")]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        if ($this->getUser()) {
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(PropertyCrudController::class)->generateUrl());
        }
        $this->addFlash('danger', "Vous devez être connecté pour accéder à l'administration");
        return $this->redirectToRoute('app_login');
        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Agency')
            ->disableDarkMode()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section("Biens", 'fas fa-users');
        yield MenuItem::linkToCrud('Nos biens', 'fas fa-list', Property::class);
        yield MenuItem::linkToCrud('Ajouter un bien', 'fas fa-list', Property::class)->setAction('new');
        yield MenuItem::linkToCrud('Bien principal', 'fas fa-list', Property::class)->setAction('detail')->setEntityId(1);

        yield MenuItem::section("Mes infos", 'fas fa-users');
        yield MenuItem::linkToCrud('Les options', 'fas fa-gear', Options::class);
        yield MenuItem::linkToCrud('Mes rendez-vous', 'fas fa-calendar-check', Appointment::class);
        yield MenuItem::section('Administration')->setPermission("ROLE_ADMIN");
        yield MenuItem::linkToCrud('Employés', 'fas fa-user', User::class)->setPermission("ROLE_ADMIN");
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFirstname()." ". $user->getLastname())
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false)

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}
