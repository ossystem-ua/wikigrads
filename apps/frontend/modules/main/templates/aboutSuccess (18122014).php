<div class="wiki-float-row"></div>
<div class="wiki-about-menu">
    <ul class="wiki-nav">
        <li><a href="#introduction">Introduction</a></li>
        <li><a href="#social-advantage">The Social Advantage</a></li>
        <li><a href="#our-mission">Our Mission</a></li>
        <li><a href="#our-business-model">Our Business Model</a></li>
        <li><a href="#about-the-founder">About the founder</a></li>
    </ul>
</div>
<div class="content-pad">
    <h1 id="introduction">Welcome to <span>WikiGrads</span></h1>
    <p>WikiGrads is a socialized communication platform that supplements face-to-face and online courses in higher education.
        We make it incredibly easy to facilitate voluntary student engagement, spontaneous peer learning, and whole-class assessment.
    </p>

    <p>The WikiGrads platform both streamlines and enhances communication by significantly upgrading the interactivity and interconnectedness of communication outside of lecture.  The platform features two communication streams for each class, the Course Feed and the Private Feeds, which respectively enable:
    </p>
        <ol>
            <li>Many-to-many communication for the entire class</li>
            <li>Student-instructor messaging and file sharing.</li>
        </ol>
    <p>Threaded Q&A, discussions, documents, images, and hyperlinks are continuously
        published over time in both feeds.  Architecting open and private feeds in parallel
        organically supports inclusive and collaborative pedagogy as well as whole-class
        and individual assessment.
    </p>

    <h4 id="social-advantage">The Social Advantage:  Voluntary Engagement and Spontaneous Learning</h4>

    <p>Socialized communication platforms are substantially more engaging,
    organized, and interconnected than discussion boards, forums, and email.
    In higher education, WikiGrads is uniquely primed to facilitate:</p>

    <p><span class="emphasized">Many-to-many communication</span> for whole-class reciprocity, collaboration,
        spontaneous learning, and alleviation of teaching pressure</p>

    <ul>
        <li>Many-to-many communication for whole-class reciprocity, collaboration, spontaneous learning, and alleviation of teaching pressure</li>
        <li>Give students an opportunity to interact with peers they would otherwise never meet.</li>
        <li>Eliminate communication redundancy, and free your email inbox.</li>
    </ul>

    <p><span class="emphasized">Transparency and peer review</span> for enhanced cognitive presence</p>

    <ul>
        <li>Transparency and peer review for enhanced cognitive presence</li>
        <li>Expose students to the work of their peers, and give them an opportunity to practice writing and responding to constructive criticism.</li>
    </ul>

    <p><span class="emphasized">A virtual sense of belonging and community</span></p>
    <ul>
        <li>A virtual sense of belonging and community</li>
        <li>Learners learn best in an environment where they have a sense of connection and feel safe to take risks.</li>
    </ul>

    <h4 id="our-mission">Our Mission</h4>
    <p>Our mission is to advance communication technology in a way that helps facilitate
        “transferable knowledge and skills in the 21st century” and “student-centered learning”.
        We believe architecting both open and private communication streams on one platform provides
        the necessary supplemental infrastructure to support “student-centered learning”.
        By leveraging social media technology and the students themselves,
        WikiGrads is primed to create peer-peer interaction on a scale that reaches
        and encourages the participation of the entire class.</p>

    <p>Exposure to variation in understanding within the class—seeing how peers understand what
        they are learning—is vital to the student’s own learning.  Compared to discussion forums or email,
        the temporal continuity of social feeds significantly enhances clarity, organization,
        and immediacy of communication.  </p>

    <p>WikiGrads supports equity in academic achievement by providing impromptu peer learning and reciprocity
        for the entire class, including students historically underserved by higher education or who have
        difficulty integrating with peers.  With support from the Learning Tools Interoperability (LTI)
        Alliance of the IMS Global Learning Consortium, the platform seamlessly integrates into your school’s LMS. </p>

    <h4 id="our-business-model">Our Business Model</h4>
    <p>WikiGrads is free for teachers and students.  During the 2014-15 academic year, we are releasing the platform
        to a limited audience (“soft launch”) in order to receive impartial feedback and determine hosting costs.
        Beginning in the fall of 2015, the platform will be delivered on demand as Software as a Service (SaaS)
        for departments and schools.  </p>

    <p>With the advent of disruptive cloud technology, the world is now shifting towards the cost-effective,
        online software delivery model.  It is our priority to ensure that the value schools and departments
        get from WikiGrads always outweighs the cost.  A web-only, lite version of the platform will always
        be free for individual teachers and students.</p>

    <p>A popular Ed-tech business model in Silicon Valley is to:
        1) make your service completely free, 2) build it up to massive scale,
        3) bundle up the millions of students, teachers, staff, and parents, and
        4) sell data about them to content providers, application developers,
        education-specific marketers, and other third parties.
        This revenue stream works at massive scale on the consumer Internet,
        but is inappropriate for education because of the loss of privacy and other conflicts of interest. </p>

    <p>WikiGrads takes the privacy of students and teachers very seriously.
        We will never sell, rent, or give away your personal information to third parties,
        nor exchange mailing lists with any other organization.  We are focused exclusively
        on servicing the needs of schools, teachers, and students.</p>

    <h4 id="about-the-founder">About the founder</h4>
    <p>Lucas DeMaio, received his B.S. in Chemical Engineering from the University of Colorado at Boulder
        and his Ph.D. in Chemical Engineering from Penn State University.  After completion of his graduate studies,
        Dr. DeMaio became a member of research staff in the Keck School of Medicine of the University of Southern California.
        He has published manuscripts in leading peer-reviewed engineering, scientific, and medical journals.
        During his graduate and postdoctoral studies, Dr. DeMaio taught and mentored undergraduate students.
        While most students successfully completed their programs, he began to notice that many of the students
        who dropped out of school lacked engagement with other students and their instructors.
        WikiGrads was born from the observation that the most important factor for student success is ongoing
        communication and interaction with peers and instructors.</p>
</div>
<div class="clear"></div>
<div class="wiki-float-row"></div>
<script type="text/javascript">
jQuery(document).ready(function(){

    //left menu move
    jQuery(window).scroll(function() {
        var top = jQuery(document).scrollTop();
        if (top < 150) jQuery(".wiki-about-menu").css({top: '0px', position: 'relative', marginTop: '50px'});
        else jQuery(".wiki-about-menu").css({top: '0px', position: 'fixed', marginTop: '10px'});
    });

    //scrool link
    jQuery('h3').append('<a href="#header"></a>');

    jQuery('a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();

        var target = this.hash,
        $target = jQuery(target);

        jQuery('ul.wiki-nav li.active').removeClass();
        jQuery(this).parent().addClass('active');

        jQuery('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 2000, 'swing', function () {
            window.location.hash = target;
        });
    });
});
</script>