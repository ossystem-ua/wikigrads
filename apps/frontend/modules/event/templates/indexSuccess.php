<h1>Events List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Course</th>
      <th>User</th>
      <th>Name</th>
      <th>Description</th>
      <th>Location</th>
      <th>Start date</th>
      <th>End date</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Deleted at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($events as $event): ?>
    <tr>
      <td><a href="<?php echo url_for('event/edit?id='.$event->getId()) ?>"><?php echo $event->getId() ?></a></td>
      <td><?php echo $event->getCourseId() ?></td>
      <td><?php echo $event->getUserId() ?></td>
      <td><?php echo $event->getName() ?></td>
      <td><?php echo $event->getDescription() ?></td>
      <td><?php echo $event->getLocation() ?></td>
      <td><?php echo $event->getStartDate() ?></td>
      <td><?php echo $event->getEndDate() ?></td>
      <td><?php echo $event->getCreatedAt() ?></td>
      <td><?php echo $event->getUpdatedAt() ?></td>
      <td><?php echo $event->getDeletedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('event/new') ?>">New</a>
