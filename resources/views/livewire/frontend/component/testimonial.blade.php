<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .professional-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .professional-wrapper {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 20px;
        padding-bottom: 20px;
    }

    .professional {
        background-color: #fff;
        flex: 0 0 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 400px;
        height: 300px;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .professional:hover {
        transform: translateY(-10px);
    }

    .professional img {
        border-radius: 15%;
        width: 80px;
        height: 80px;
        object-fit: cover;
    }

    .scroll-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .scroll-button:hover {
        background-color: #0056b3;
    }

    @media (max-width: 768px) {
        .professional {
            flex: 0 0 70%;
            max-width: 70%;
            margin: 10px;
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .professional {
            flex: 0 0 90%;
            max-width: 90%;
            margin: 10px;
            padding: 15px;
        }

        .professional img {
            width: 60px;
            height: 60px;
        }
    }

    .professional-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 20px;
    }

    .professional-text {
        flex: 1;
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="professional-container">
        <section class="hj rp hr">
            <!-- Section Title Start -->
            <div class="animate_top bb ze rj ki xn vq">
                <h2 class="fk vj pr kk wm on/5 gq/2 bb _b">
                    Testimonials
                </h2>
            </div>
            <!-- Section Title End -->

            <div class="bb ze ki xn ar">
                <div class="animate_top jb cq professional-wrapper">
                    <!-- Professional 1 -->
                    <div class="professional">
                        <div class="professional-content">
                            <div class="tc sf rn tn un zf dp">
                                <img class="bf w-24 h-24" src="{{ asset('./assets/img/software_developer.jpg') }}"
                                    alt="Software Developer" />
                            </div>
                            <div class="professional-text">
                                <h3>Software Developer/Engineer</h3>
                                <p>Specializes in developing applications and systems. Works with various programming
                                    languages and frameworks to build software solutions.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional 2 -->
                    <div class="professional">
                        <div class="professional-content">
                            <div class="tc sf rn tn un zf dp">
                                <img class="bf w-24 h-24" src="{{ asset('/public/assets/img/devops_engineer.jpg') }}"
                                    alt="DevOps Engineer" />
                            </div>
                            <div class="professional-text">
                                <h3>DevOps Engineer</h3>
                                <p>Focuses on the integration and deployment of software, ensuring that development and
                                    operations work smoothly together using tools like Docker and Kubernetes.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional 3 -->
                    <div class="professional">
                        <div class="professional-content">
                            <div class="tc sf rn tn un zf dp">
                                <img class="bf w-24 h-24" src="/assets/img/testimonial3-removebg-review.png"
                                    alt="Data Scientist" />
                            </div>
                            <div class="professional-text">
                                <h3>Data Scientist/Analyst</h3>
                                <p>Analyzes and interprets complex data to help organizations make informed decisions,
                                    using tools and languages like Python, R, and SQL.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional 4 -->
                    <div class="professional">
                        <div class="professional-content">
                            <div class="tc sf rn tn un zf dp">
                                <img class="bf w-24 h-24"
                                    src="{{ asset('/assets/img/testimonial5-removebg-review.png') }}"
                                    alt="testimonial4-removebg-review" />
                            </div>
                            <div class="professional-text">
                                <h3>System Administrator</h3>
                                <p>Manages and maintains an organization's IT infrastructure, ensuring systems are
                                    running smoothly and securely.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional 5 -->
                    <div class="professional">
                        <div class="professional-content">
                            <div class="tc sf rn tn un zf dp">
                                <img class="bf w-24 h-24"
                                    src="{{ asset('/assets/img/testimonial5-removebg-review.png') }}"
                                    alt="testimonial5-removebg-review" />
                            </div>
                            <div class="professional-text">
                                <h3>Cybersecurity expert</h3>
                                <p>Protects an organization's systems and data from cyber threats, focusing on threat
                                    detection, response, and prevention.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional professionals can be added here in the same format -->
                </div>
            </div>
        </section>
        <button class="scroll-button"
            onclick="document.querySelector('.professional-wrapper').scrollBy({ left: 300, behavior: 'smooth' });">
            Scroll for more
        </button>
    </div>
</body>

</html>