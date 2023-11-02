<?php

namespace Database\Seeders;

use Database\Factories\FragmentFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FragmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FragmentFactory::new()
            ->count(17)
            ->state(new Sequence(...$this->sequence()))
            ->create();
    }

    private function sequence(): array
    {
        return [
            [
                'title_ru' => 'Суть инновационного образования, заключается в квалифицированном содействии, Развития у ребенка.',
                'title_en' => 'The essence of innovative education is the qualified assistance of Development in the child.',
            ],
            [
                'title_ru' => 'Мальчик положил Начало Изучению Сути Глобального Зла. Поэтому это было началом Сопротивления Глобальному Злу.',
                'title_en' => 'As the Boy put the Beginning of the Study of the Essence of Global Evil . Therefore, this was the beginning of Resistance to Global Evil.',
            ],
            [
                'title_ru' => 'На Заре Человеческой Цивилизации Криминалитет Эволюционировал из бытового уголовника в Государственную Организованную Преступность.',
                'title_en' => 'At the dawn of Human Civilization, criminality evolved from a domestic criminal to State Organized Crime.',
            ],
            [
                'title_ru' => 'Начиная с рождения ребенка,  психическая эволюция Самосознания, до того момента, когда ребенок ставит себе Вопрос?',
                'title_en' => 'Beginning from birth, the psychic evolution of Self-consciousness to the point where the child asks himself the Question.',
            ],
            [
                'title_ru' => 'Общие подходы в обучении. Медицинско-профилактическое просвещение. Санитарно-гигиенические запросы ребенка',
                'title_en' => 'General approaches to teaching. Medical and preventive education. Sanitary and hygienic needs of the child.',
            ],
            [
                'title_ru' => 'Организация тестирования ученика—ребенка на возможные варианты профессионального будущего или бизнес-технологического будущего.',
                'title_en' => 'Assessing the student (child) for professional carrier options or a future in business and technology.',
            ],
            [
                'title_ru' => 'План и программа действий «Городской РЕГИОНАЛЬНОЙ ХРИСТИАНСКОЙ Демократической партии»',
                'title_en' => 'Plan and program of "Metropolitan REGIONAL CHRISTIAN Democratic Party"',
            ],
            [
                'title_ru' => 'Общество в постсоветском пространстве, психически мутировано, то есть процесс эволюции сознания и самосознания находится на животном уровне.',
                'title_en' => 'In the post-Soviet space, society is mentally mutated, i.e. the process of evolution of consciousness and self-consciousness is at an animal level.',
            ],
            [
                'title_ru' => 'И что произошло в 1917 году?  А то, что главный большевик и коммунист Ленин, после насильственного большевистко-комуннистического переворота в России экспортировал коммунизм в Ригу.',
                'title_en' => '',
            ],
            [
                'title_ru' => 'Что собой представляет структура  государственной власти  в Постсоветских республиках?',
                'title_en' => 'What is the structure of state power in the post-Soviet republics?',
            ],
            [
                'title_ru' => 'Почему невозможно  развивать   бизнес  в Постсоветском пространстве.',
                'title_en' => 'Why it is impossible to develop business in the post-Soviet space.',
            ],
            [
                'title_ru' => 'Что представляет Россия!',
                'title_en' => 'What Russia represents!',
            ],
            [
                'title_ru' => 'Демократия оценивается.',
                'title_en' => 'Democracy is assessed',
            ],
            [
                'title_ru' => 'Проблемы современной иммиграционной политики Западной Европы, Северной Америки, Канады, Новой Зеландии, Австралии',
                'title_en' => 'Problems of Modern Immigration Policy in Western Europe, North America, Canada, New Zealand, and Australia.',
            ],
            [
                'title_ru' => 'Сущность Национализма в формате психоанализа',
                'title_en' => 'The essence of Nationalism in the format of psychoanalysis.',
            ],
            [
                'title_ru' => 'Поэтому необходимо раскрыть секреты и парадоксы форсирования Экономического развития стран с Автолитарно-Криминальными режимами.',
                'title_en' => 'Therefore, it is necessary to reveal the secrets and paradoxes of forcing economic development in countries with autocratic-criminal regimes. ',
            ],
            [
                'title_ru' => 'Ранее описывались Стратегически-фундаментальные причины, по которым ведущий родовой клан добивается Главенства в политике.',
                'title_en' => 'We previously described strategically fundamental reasons why the leading clan seeks Primacy in politics.',
            ],
        ];
    }
}
