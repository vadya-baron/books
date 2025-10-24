<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\src\App\UseCases\BookUseCase;
use app\src\Domain\Entities\Author;
use app\src\Domain\Forms\BookForm;
use app\src\Domain\Repositories\AuthorRepository;
use app\src\Domain\Repositories\BookRepository;
use app\src\Domain\ValueObjects\AuthorKey;
use app\src\Domain\ValueObjects\ISBN;
use DateTimeImmutable;
use Exception;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly AuthorRepository $authorRepository,
        private readonly BookRepository $bookRepository,
        private readonly BookUseCase $createBookUseCase,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex($message = 'Заполнение исходными данными'): int
    {
        echo $message . "\n";

        if (!$this->seedAuthors()) {
            return ExitCode::IOERR;
        }

        if (!$this->seedBooks()) {
            return ExitCode::IOERR;
        }

        return ExitCode::OK;
    }

    private function seedAuthors(): bool
    {
        try {
            $key = new AuthorKey('Скотт Миллетт');
            if (empty($this->authorRepository->findByKey($key))) {
                $this->authorRepository->save(new Author(
                    id: null,
                    fullName: 'Скотт Миллетт',
                    key: $key
                ));
            }

            $key = new AuthorKey('Ник Тьюн');
            if (empty($this->authorRepository->findByKey($key))) {
                $this->authorRepository->save(new Author(
                    id: null,
                    fullName: 'Ник Тьюн',
                    key: $key
                ));
            }

            $key = new AuthorKey('Родку Гонди');
            if (empty($this->authorRepository->findByKey($key))) {
                $this->authorRepository->save(new Author(
                    id: null,
                    fullName: 'Родку Гонди',
                    key: $key
                ));
            }

            $key = new AuthorKey('Нил Форд');
            if (empty($this->authorRepository->findByKey($key))) {
                $this->authorRepository->save(new Author(
                    id: null,
                    fullName: 'Нил Форд',
                    key: $key
                ));
            }

            $key = new AuthorKey('Марк Ричардс');
            if (empty($this->authorRepository->findByKey($key))) {
                $this->authorRepository->save(new Author(
                    id: null,
                    fullName: 'Марк Ричардс',
                    key: $key
                ));
            }

            $key = new AuthorKey('Адитья Бхаргава');
            if (empty($this->authorRepository->findByKey($key))) {
                $this->authorRepository->save(new Author(
                    id: null,
                    fullName: 'Адитья Бхаргава',
                    key: $key
                ));
            }

            $key = new AuthorKey('Лидия Юрьевна Егорова');
            if (empty($this->authorRepository->findByKey($key))) {
                $this->authorRepository->save(new Author(
                    id: null,
                    fullName: 'Лидия Юрьевна Егорова',
                    key: $key
                ));
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";

            return false;
        }

        return true;
    }

    private function seedBooks(): bool {
        $domainDrivenDesign = new ISBN('978-5-496-01984-2');
        $softwareArchitecture = new ISBN('978-601-08-4838-2');
        $grokAlgorithms = new ISBN('978-5-4461-4172-2');

        try {
            if (empty($this->bookRepository->findByIsbn($domainDrivenDesign))) {
                $authorScottMillett = $this->authorRepository->findByKey(new AuthorKey('Скотт Миллетт'));
                $authorNickTune = $this->authorRepository->findByKey(new AuthorKey('Ник Тьюн'));

                $form = new BookForm($this->authorRepository);
                $form->title = 'Предметно-ориентированное проектирование: паттерны, принципы и методы';
                $form->pubYear = 2017;
                $form->description = 'Предметно-ориентированное проектирование - это процесс тесной увязки программного...';
                $form->isbn = $domainDrivenDesign;
                $form->imageUrl = 'https://img.mdk-arbat.ru/main/93/61/936167.jpg';
                $form->authorIDs = [$authorScottMillett->id(), $authorNickTune->id()];

                $this->createBookUseCase->execute($form);
            }

            if (empty($this->bookRepository->findByIsbn($softwareArchitecture))) {
                $authorRodkuGondi = $this->authorRepository->findByKey(new AuthorKey('Родку Гонди'));
                $authorNeilFord = $this->authorRepository->findByKey(new AuthorKey('Нил Форд'));
                $authorMarkRichards = $this->authorRepository->findByKey(new AuthorKey('Марк Ричардс'));

                $form = new BookForm($this->authorRepository);
                $form->title = 'Head First. Архитектура ПО';
                $form->pubYear = 2025;
                $form->description = 'Плох тот разработчик, который не мечтает стать архитектором!';
                $form->isbn = $softwareArchitecture;
                $form->imageUrl = 'https://img.mdk-arbat.ru/main/67/11/6711041.jpg';
                $form->authorIDs = [$authorRodkuGondi->id(), $authorNeilFord->id(), $authorMarkRichards->id()];

                $this->createBookUseCase->execute($form);
            }

            if (empty($this->bookRepository->findByIsbn($grokAlgorithms))) {
                $authorAdityaBhargava = $this->authorRepository->findByKey(new AuthorKey('Адитья Бхаргава'));
                $authorLydiaYurievnaEgorova = $this->authorRepository->findByKey(new AuthorKey('Лидия Юрьевна Егорова'));

                $form = new BookForm($this->authorRepository);
                $form->title = 'Грокаем алгоритмы';
                $form->pubYear = 2025;
                $form->description = 'Алгоритмы - это пошаговые инструкции решения задач, большинство из которых уже...';
                $form->isbn = $grokAlgorithms;
                $form->imageUrl = 'https://img.mdk-arbat.ru/main/66/96/6696488.jpg';
                $form->authorIDs = [$authorAdityaBhargava->id(), $authorLydiaYurievnaEgorova->id()];

                $this->createBookUseCase->execute($form);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";

            return false;
        }

        return true;
    }
}
