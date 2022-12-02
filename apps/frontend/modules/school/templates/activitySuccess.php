<h1>Schools List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Twitter list</th>
      <th>First friend</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Deleted at</th>
      <th>Slug</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($schools as $school): ?>
    <tr>
      <td><a href="<?php echo url_for('school/edit?id='.$school->getId()) ?>"><?php echo $school->getId() ?></a></td>
      <td><?php echo $school->getName() ?></td>
      <td><?php echo $school->getTwitterList() ?></td>
      <td><?php echo $school->getFirstFriendId() ?></td>
      <td><?php echo $school->getCreatedAt() ?></td>
      <td><?php echo $school->getUpdatedAt() ?></td>
      <td><?php echo $school->getDeletedAt() ?></td>
      <td><?php echo $school->getSlug() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('school/new') ?>">New</a>
