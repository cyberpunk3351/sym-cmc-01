<?php

namespace App\Controller\Admin;

use App\Entity\Post;
Use App\Controller\TagController;
use App\Entity\Tag;
use App\Form\TagType;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;


class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $imageFile = ImageField::new('thumbnailFile')->setFormType(VichImageType::class);
        $image = ImageField::new('thumbnails')->setBasePath('/uploads/files');
        $fields = [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('category'),
            AssociationField::new('tags')->setFormTypeOptions([
                'by_reference' => false,
            ]),
            TextField::new('title'),
            TextEditorField::new('content'),
            Field::new('published'),
            DateTimeField::new('createdAt')
        ];

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $image;
         } else {
            $fields[] = $imageFile;
        }

        return $fields;
    }

}
