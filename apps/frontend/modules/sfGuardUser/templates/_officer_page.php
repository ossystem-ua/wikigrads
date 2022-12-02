<h2>Officer page</h2>

<div class="officer-content">
<h3>About</h3>
The officer has the opportunity to sign up for any course.
In the course of our subscription officer is not displayed.
The officer on the forum can delete, edit all posts and comments.
Officer may be added to the course forum posts and comments.
<div class="wiki-float-row"></div>

<h3><?php echo link_to("Instructor course", "/officer/course", array('data-id' => "-100", 'class' => 'tb-link')); ?></h3>
<ul>
    <li>Change the code to the course instructor.</li>
    <li>Removed a instructor from the course.</li>
</ul>
The section shows the full list of instructors.
<div class="wiki-float-row"></div>

<h3><?php echo link_to("Join to course", "/officer/join", array('data-id' => "-100", 'class' => 'tb-link')); ?></h3>
<ul>
    <li>Subscribe to any course.</li>
</ul>
The list displays only those courses that are not signed by the officer.
<div class="wiki-float-row"></div>

<?php/*
<h3><?php echo link_to("My posts", "/officer/post", array('data-id' => "-100", 'class' => 'tb-link')); ?></h3>
Information section on every post officer for all courses.

*/?>
</div>
<div class="wiki-float-row"></div>