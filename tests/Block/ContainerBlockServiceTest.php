<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DashboardBundle\Tests\Block;

use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Test\AbstractBlockServiceTestCase;
use Sonata\DashboardBundle\Block\ContainerBlockService;

/**
 * Test Container Block service.
 */
class ContainerBlockServiceTest extends AbstractBlockServiceTestCase
{
    /**
     * test the block execute() method.
     */
    public function testExecute(): void
    {
        $service = new ContainerBlockService('core.container', $this->templating);

        $block = new Block();
        $block->setName('block.name');
        $block->setType('core.container');
        $block->setSettings([
            'code' => 'block.code',
        ]);

        $blockContext = new BlockContext($block, [
            'code' => '',
            'layout' => '{{ CONTENT }}',
            'class' => '',
            'template' => '@SonataDashboard/BlockAdmin/block_container.html.twig',
        ]);

        $service->execute($blockContext);

        $this->assertEquals('@SonataDashboard/BlockAdmin/block_container.html.twig', $this->templating->view);
        $this->assertEquals('block.code', $this->templating->parameters['block']->getSetting('code'));
        $this->assertEquals('block.name', $this->templating->parameters['block']->getName());
        $this->assertInstanceOf('Sonata\BlockBundle\Model\Block', $this->templating->parameters['block']);
    }

    /**
     * test the container layout.
     */
    public function testLayout(): void
    {
        $service = new ContainerBlockService('core.container', $this->templating);

        $block = new Block();
        $block->setName('block.name');
        $block->setType('core.container');

        // we manually perform the settings merge
        $blockContext = new BlockContext($block, [
            'code' => 'block.code',
            'layout' => 'before{{ CONTENT }}after',
            'class' => '',
            'template' => '@SonataDashboard/BlockAdmin/block_container.html.twig',
        ]);

        $service->execute($blockContext);

        $this->assertInternalType('array', $this->templating->parameters['decorator']);
        $this->assertArrayHasKey('pre', $this->templating->parameters['decorator']);
        $this->assertArrayHasKey('post', $this->templating->parameters['decorator']);
        $this->assertEquals('before', $this->templating->parameters['decorator']['pre']);
        $this->assertEquals('after', $this->templating->parameters['decorator']['post']);
    }

    /**
     * test the block's form builders.
     */
    public function testFormBuilder(): void
    {
        $service = new ContainerBlockService('core.container', $this->templating);

        $block = new Block();
        $block->setName('block.name');
        $block->setType('core.container');
        $block->setSettings([
            'name' => 'block.code',
        ]);

        $formMapper = $this->createMock('Sonata\\AdminBundle\\Form\\FormMapper', [], [], '', false);
        $formMapper->expects($this->exactly(6))->method('add');

        $service->buildCreateForm($formMapper, $block);
        $service->buildEditForm($formMapper, $block);
    }
}
