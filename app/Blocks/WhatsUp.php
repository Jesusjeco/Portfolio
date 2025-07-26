<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class WhatsUp extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Whats Up';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Profile, title and social icons';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'design';

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
        'anchor' => true,
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
     * Process socials to return only icon IDs while keeping structure
     */
    public function processSocials(): array
    {
        $socials = get_field('socials');
        
        if ($socials) {
            foreach ($socials as &$social) {
                if (isset($social['icon']) && is_array($social['icon'])) {
                    $social['icon'] = $social['icon']['ID'];
                }
            }
        }

        return $socials ?: [];
    }

    /**
     * Data to be passed to the block before rendering.
     */
    public function with(): array
    {
        return [
            'profile' => get_field('profile', false, false),
            'title' => get_field('title'),
            'description' => get_field('description'),
            'socials' => $this->processSocials(),
        ];
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('whats_up');

        $fields
            ->addImage('profile')
            ->addText('title')
            ->addText('description')
            ->addRepeater('socials')
                ->addImage('icon')
                ->addLink('link')
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
