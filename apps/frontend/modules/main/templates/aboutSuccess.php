<div class="wiki-float-row"></div>
<div class="wiki-about-menu">
    <ul class="wiki-nav">
        <li><a href="#introduction">Welcome to WikiGrads </a></li>
        <li><a href="#our-mission">Our Mission</a></li>
        <li><a href="#our-business-model">Our Business Model</a></li>
        <li><a href="#our-about-the-founder">About the founder</a></li>
    </ul>
</div>
<div class="content-pad">
    <h1 id="introduction">Welcome to <span>WikiGrads</span></h1>
    <p>
        WikiGrads is a social learning platform that seamlessly extends your 
        lecture into a blended environment for peer-to-peer interaction and 
        learning outside the classroom.  We make it incredibly easy to share 
        dialogue and digital content—documents, web links, images, videos, 
        and LaTeX equations—on a platform that features a shared activity 
        stream for the entire class.  Activity streams with rich communication 
        tools allows for multiple representations of course material from 
        multiple perspectives, helping to deepen learning and streamline 
        communication simultaneously.  Activity streams powered by social 
        media technology are the future of teaching and learning outside the 
        classroom!
    </p>

    <p>
        In today’s individualistic and competitive learning environments, 
        we are throwing away tremendous amounts of pedagogical value by 
        failing to provide social tools that leverage differences in 
        understanding between the students themselves.  Exposure to variation 
        in understandings within the class—seeing how peers communicate and 
        understand what they are learning—can dramatically accelerate a 
        student’s own understanding.
    </p>
    
    <p>
        LMS discussion boards and forums are virtually dead in higher education.  
        Their interfaces are more static and layered with limited interactivity.  
        Web-based environments built around activity streams are much more 
        interactive and user-friendly.  In contrast to face-to-face 
        environments, activity streams leave a record of all dialogue and 
        collaborative activities.
    </p>

    <p>
        Energize classroom teaching, maximize learning potential, and alleviate 
        teaching pressure simultaneously.  Become more of a facilitator of 
        learning, and create a blended environment where teaching and learning 
        are collaborative and reciprocal.  Students will interact with peers 
        they do not know or perhaps never will meet in person!
    </p>
    
    <p>
        WikiGrads is a simple plug and play learning application that integrates 
        with your School’s LMS using the IMS Learning Tools Interoperability 
        (LTI) standard.
    </p>

    <h4 id="our-mission">Our Mission</h4>
        
    <p>
        Our mission is to evolve classroom teaching into blended environments 
        for deeper learning.  Oddly, translations of constructivist learning 
        theory into educational technology have largely excluded the important 
        process of meaning making through social interaction between the 
        students themselves.  By leveraging social media technology, WikiGrads 
        is primed to create peer-to-peer interaction on a scale that reaches 
        and encourages the participation of the entire class.  Adding more 
        student voices, perspectives, and content is virtually guaranteed to 
        energize teaching and learning.
    </p>
    
    <h4 id="our-business-model">Our Business Model</h4>
    
    <p>
        WikiGrads is free for individual teachers and their students.  
        In January of 2015, we will begin a “soft” launch (pilot phase) 
        across a few campuses in Southern California.  We are excited to test 
        product viability and gather data on usage and acceptance across various
        academic departments within higher education.  In the near future, we 
        aim to license the platform to departments and institutions using the 
        Software as a Service (SaaS) business model.  With the advent of cloud 
        technology, the world is now shifting towards the cost-effective, 
        web-based delivery model.  There is no software to install.  It is our 
        priority to ensure that the value schools and departments get from 
        WikiGrads always outweighs the cost.
    </p>
    
    <p>
        A popular Ed-tech business model in Silicon Valley is to:  1) make your 
        service completely free, 2) build it up to massive scale, 3) bundle up 
        the millions of students, teachers, staff, and parents, and 4) sell data
        about them to content providers, application developers, 
        education-specific marketers, and other third parties.  This revenue 
        stream works at massive scale on the consumer Internet, but is 
        inappropriate for education because of the loss of privacy and other 
        conflicts of interest. 
    </p>
    
    <p>
        WikiGrads takes the privacy of students and teachers very seriously.  
        We will never sell, rent, or give away your personal information to 
        third parties, nor exchange mailing lists with any other organization.  
        We are focused exclusively on servicing the needs of schools, teachers, 
        and students.
    </p>
    
    <h4 id="our-about-the-founder">About the founder</h4>
    
    <p>
        Lucas DeMaio, received his B.S. in Chemical Engineering from the 
        University of Colorado at Boulder and his Ph.D. in Chemical Engineering 
        from Penn State University.  After completion of his graduate studies, 
        Dr. DeMaio became a member of research staff in the Keck School of 
        Medicine of the University of Southern California.  He has published 
        manuscripts in leading peer-reviewed engineering, scientific, and 
        medical journals. During his graduate and postdoctoral studies, 
        Dr. DeMaio taught and mentored undergraduate students.  While most 
        students successfully completed their programs, he began to notice that 
        many of the students who dropped out of school lacked a social 
        connection with other students and their instructors.  WikiGrads was 
        born from the observation that the most important factor for student 
        success is ongoing communication and interaction with peers and 
        instructors.
    </p>
    
    <p>
        
    </p>
    
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