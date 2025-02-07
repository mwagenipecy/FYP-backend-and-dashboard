<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Testimonials</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .testimonial-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .testimonial-wrapper {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 20px;
        padding-bottom: 20px;
    }

    .testimonial {
        background-color: #fff;
        flex: 0 0 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 400px;
        height: 200px;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .testimonial:hover {
        transform: translateY(-10px);
    }

    .testimonial img {
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
        .testimonial {
            flex: 0 0 70%;
            max-width: 70%;
            margin: 10px;
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .testimonial {
            flex: 0 0 90%;
            max-width: 90%;
            margin: 10px;
            padding: 15px;
        }

        .testimonial img {
            width: 60px;
            height: 60px;
        }
    }
    </style>
</head>

<body>
    <div class="testimonial-container">
        <section class="hj rp hr">
            <!-- Section Title Start -->
            <div class="animate_top bb ze rj ki xn vq">
                <h2 class="fk vj pr kk wm on/5 gq/2 bb _b">
                    Student Testimonials
                </h2>
            </div>
            <!-- Section Title End -->

            <div class="bb ze ki xn ar">
                <div class="animate_top jb cq testimonial-wrapper">
                    <!-- Testimonial 1 -->
                    <div class="testimonial">
                        <div class="tc sf rn tn un zf dp">
                            <img class="bf w-24 h-24" src="https://via.placeholder.com/80" alt="User 1" />
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="testimonial">
                        <div class="tc sf rn tn un zf dp">
                            <img class="bf w-24 h-24" src="https://via.placeholder.com/80" alt="User 2" />
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="testimonial">
                        <div class="tc sf rn tn un zf dp">
                            <img class="bf w-24 h-24" src="https://via.placeholder.com/80" alt="User 3" />
                        </div>
                    </div>

                    <!-- Testimonial 4 -->
                    <div class="testimonial">
                        <div class="tc sf rn tn un zf dp">
                            <img class="bf w-24 h-24" src="https://via.placeholder.com/80" alt="User 4" />
                        </div>
                    </div>

                    <!-- Testimonial 5 -->
                    <div class="testimonial">
                        <div class="tc sf rn tn un zf dp">
                            <img class="bf w-24 h-24" src="https://via.placeholder.com/80" alt="User 5" />
                        </div>
                    </div>

                    <!-- Additional testimonials can be added here in the same format -->
                </div>
            </div>
        </section>
        <button class="scroll-button"
            onclick="document.querySelector('.testimonial-wrapper').scrollBy({ left: 300, behavior: 'smooth' });">
            Scroll for more
        </button>
    </div>
</body>

</html>