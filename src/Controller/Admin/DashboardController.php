<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use App\Entity\LegalPerson;
use App\Entity\NaturalPerson;
use App\Entity\Address;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_SUPERADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/superadmin", name="superadmin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<h1 class="text-end" style="font-weight: bold; font-style: italic">SUPER-ADMIN</h1>')
            ->setFaviconPath('build/images/Logos/faviconJM.png')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('<img src="/build/images/Logos/LogoLJMBWhite.png">');
        yield MenuItem::linktoDashboard('Tableau de bord', '');
        yield MenuItem::linkToCrud('Personnes morales', '', LegalPerson::class);
        yield MenuItem::linkToCrud('Personnes physiques', '', NaturalPerson::class);
        yield MenuItem::linkToCrud('Adresses', '', Address::class);
        yield MenuItem::linkToCrud('Utilisateurs', '', User::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('build/superAdmin.css');
    }
}
