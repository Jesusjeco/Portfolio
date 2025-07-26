<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class MySkills extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'My Skills';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'List of skills with icon and name';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'media';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'editor-ul';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = [];

    /**
     * The block post type allow list.
     *
     * @var array
     */
    public $post_types = [];

    /**
     * The parent block type allow list.
     *
     * @var array
     */
    public $parent = [];

    /**
     * The ancestor block type allow list.
     *
     * @var array
     */
    public $ancestor = [];

    /**
     * The default block mode.
     *
     * @var string
     */
    public $mode = 'preview';

    /**
     * The default block alignment.
     *
     * @var string
     */
    public $align = '';

    /**
     * The default block text alignment.
     *
     * @var string
     */
    public $align_text = '';

    /**
     * The default block content alignment.
     *
     * @var string
     */
    public $align_content = '';

    /**
     * The default block spacing.
     *
     * @var array
     */
    public $spacing = [
        'padding' => null,
        'margin' => null,
    ];

    /**
     * The supported block features.
     *
     * @var array
     */
    public $supports = [
        'align' => false,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => false,
        'mode' => true,
        'multiple' => true,
        'jsx' => true,
        'color' => [
            'background' => false,
            'text' => false,
            'gradients' => false,
        ],
        'spacing' => [
            'padding' => false,
            'margin' => false,
        ],
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = ['light', 'dark'];

    /**
     * Data to be passed to the block before rendering.
     */
    public function with(): array
    {
        return [
            'title' => get_field('title'),
            'skills' => $this->skills(),
        ];
    }

    /**
     * Process skills repeater field to return only icon IDs and process badges.
     */
    public function skills(): array
    {
        $skills = get_field('skills') ?: [];
        
        return array_map(function ($skill) {
            // Process badges repeater
            $badges = [];
            if (isset($skill['badges']) && is_array($skill['badges'])) {
                $badges = array_map(function ($badge) {
                    return [
                        'name' => $badge['name'] ?? '',
                    ];
                }, $skill['badges']);
            }

            return [
                'name' => $skill['name'] ?? '',
                'icon' => is_array($skill['icon']) ? $skill['icon']['ID'] : $skill['icon'],
                'badges' => $badges,
            ];
        }, $skills);
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('my_skills');

        $fields
            ->addText('title')
            ->addRepeater('skills')
                ->addImage('icon')
                ->addText('name')
                ->addRepeater('badges')
                    ->addText('name')
                ->endRepeater()
            ->endRepeater();

        return $fields->build();
    }

    /**
     * Assets enqueued with 'enqueue_block_assets' when rendering the block.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/#editor-content-scripts-and-styles
     */
    public function assets(array $block): void
    {
        //
    }
}
