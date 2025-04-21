<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .columns-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .column {
        flex: 1;
        margin: 30px;
        box-sizing: border-box;
    }

    h1 {
        font-weight: bold;
        font-size: 32px;
        color: black;
    }

    p {
        color: black;
        margin-bottom: 15px;
        text-align: justify;
        /* This ensures the text is justified */
    }

    @media (max-width: 768px) {
        .column {
            flex: 1 1 100%;
            margin-right: 0;
            margin-bottom: 20px;
        }
    }
    </style>
</head>

<body>
    <div>
        <section class="hj rp hr">
            <!-- Section Title Start -->
            <div class="bb ze ki xn ar">
                <div class="animate_top jb cq">
                    <!-- Columns Container -->
                    <div class="columns-container">
                        <!-- Column 1: Our Mission -->
                        <div class="column">
                            <h1>Our Mission</h1>
                            <p class="mt-4 text-gray-700 text-lg leading-relaxed">
                                Use open innovation to solve community challenges.
                            </p>
                            <p class="mt-4 text-gray-700 text-lg leading-relaxed">
                                {{ $this->hub->mission }}
                            </p>
                        </div>
                        <!-- Column 2: Our Vision -->
                        <div class="column">
                            <h1>Our Vision</h1>
                            <p class="mt-4 text-gray-700 text-lg leading-relaxed">
                               {{ $this->hub->vision }}
                            </p>
                        </div>
                        <!-- Column 3: What We Do -->
                        <div class="column">
                            <h1>What We Do</h1>
                            <p class="mt-4 text-gray-700 text-lg leading-relaxed">
                               {{ $this->hub->description }}
                            </p>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- Section Title End -->
        </section>
    </div>
</body>

</html>