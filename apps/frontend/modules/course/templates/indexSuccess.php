<h1>Courses List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Department</th>
      <th>Name</th>
      <th>Code</th>
      <th>Instructor</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Deleted at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($courses as $course): ?>
    <tr>
      <td><a href="<?php echo url_for('course/edit?id='.$course->getId()) ?>"><?php echo $course->getId() ?></a></td>
      <td><?php echo $course->getDepartmentId() ?></td>
      <td><?php echo $course->getName() ?></td>
      <td><?php echo $course->getCode() ?></td>
      <td><?php echo $course->getInstructor() ?></td>
      <td><?php echo $course->getCreatedAt() ?></td>
      <td><?php echo $course->getUpdatedAt() ?></td>
      <td><?php echo $course->getDeletedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('course/new') ?>">New</a>
