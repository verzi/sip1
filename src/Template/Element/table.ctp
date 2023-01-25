<table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('brand') ?></th>
                <th><?= $this->Paginator->sort('model') ?></th>
                <th><?= $this->Paginator->sort('km') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($rows as $row): ?>
            <tr>
                <td><?= $this->Number->format($row->id) ?></td>
                <td><?= h($row->brand) ?></td>
                <td><?= h($row->model) ?></td>
                <td><?= h($row->km) ?></td>
                <td><?= h($row->created) ?></td>
                <td><?= h($row->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $row->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $row->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $row->id], ['confirm' => __('Are you sure you want to delete # {0}?', $row->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>