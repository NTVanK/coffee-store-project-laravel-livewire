<div class="mt-3 p-3 brand-component">

    <h1 class="title">Thương hiệu hợp tác nổi tiếng</h1>
    <hr class="w-50">

    <div class="marquee">
        <ul class="marquee-content">
            @foreach ($brands as $brand)
                <li>
                    <img src="{{ $brand->image }}" alt="img">
                </li>
            @endforeach
        </ul>

    </div>

    <style>
        .brand-component {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: var(--coffee-brown);

            .title {
                width: max-content;
                color: var(--milk);
                font-family: Serif;
            }

            hr {
                color: var(--milk);
            }
        }

        :root {
            --marquee-width: 100vw;
            --marquee-height: 20vh;
            /* --marquee-elements: 12; */
            /* defined with JavaScript */
            --marquee-elements-displayed: 5;
            --marquee-element-width: calc(var(--marquee-width) / var(--marquee-elements-displayed));
            --marquee-animation-duration: calc(var(--marquee-elements) * 3s);
        }

        .marquee {
            width: var(--marquee-width);
            height: var(--marquee-height);
            overflow: hidden;
            position: relative;
        }

        .marquee:before,
        .marquee:after {
            position: absolute;
            top: 0;
            width: 10rem;
            height: 100%;
            content: "";
            z-index: 1;
        }

        .marquee:before {
            left: 0;
            background: linear-gradient(to right, #111 0%, transparent 100%);
        }

        .marquee:after {
            right: 0;
            background: linear-gradient(to left, #111 0%, transparent 100%);
        }

        .marquee-content {
            list-style: none;
            height: 100%;
            display: flex;
            animation: scrolling var(--marquee-animation-duration) linear infinite;
        }

        /* .marquee-content:hover {
  animation-play-state: paused;
} */
        @keyframes scrolling {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-1 * var(--marquee-element-width) * var(--marquee-elements)));
            }
        }

        .marquee-content li {
            display: flex;
            justify-content: center;
            align-items: center;
            /* text-align: center; */
            flex-shrink: 0;
            width: var(--marquee-element-width);
            max-height: 100%;
            font-size: calc(var(--marquee-height)*3/4);
            /* 5rem; */
            white-space: nowrap;
        }

        .marquee-content li img {
            height: 100%;
            object-fit: cover;
            border-radius: 1rem;
        }

        @media (max-width: 600px) {
            html {
                font-size: 12px;
            }

            :root {
                --marquee-width: 100vw;
                --marquee-height: 16vh;
                --marquee-elements-displayed: 3;
            }

            .marquee:before,
            .marquee:after {
                width: 5rem;
            }
        }
    </style>

    <script>
        const root = document.documentElement;
        const marqueeElementsDisplayed = getComputedStyle(root).getPropertyValue("--marquee-elements-displayed");
        const marqueeContent = document.querySelector("ul.marquee-content");

        root.style.setProperty("--marquee-elements", marqueeContent.children.length);

        for (let i = 0; i < marqueeElementsDisplayed; i++) {
            marqueeContent.appendChild(marqueeContent.children[i].cloneNode(true));
        }
    </script>
</div>
