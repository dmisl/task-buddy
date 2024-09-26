@extends('main')

@section('title', 'My week')

@section('style')
    @vite('resources/css/goalShow.css')
@endsection

@section('content')

<div class="content__container">
    <div class="content">
        <div class="tasks">
            <div class="tasks__title">
                <h1>Цілі і завдання</h1>
            </div>
            <div class="tasks__flex__container">
                <div class="tasks__flex" id="x-custom__scrollbar">
                    {{-- UNFINISHED --}}
                    <div class="tasks__flex__block__parent">
                        <div class="tasks__flex__block unfinished">
                            <div class="title">
                                Незавершені
                            </div>
                            <div class="flex">
                                <div class="task p5">
                                    <p>Завершити блок з цілями<span>...</span></p>
                                </div>
                                <div class="task p4">
                                    <p>Завершити блок з цілями<span>...</span></p>
                                </div>
                                <div class="task p3">
                                    <p>Завершити блок з цілями<span>...</span></p>
                                </div>
                                <div class="task p2">
                                    <p>Завершити блок з цілями<span>...</span></p>
                                </div>
                                <div class="task p1">
                                    <p>Завершити блок з цілями<span>...</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($goals as $goal)
                        <div class="tasks__flex__block__parent">
                            <div class="tasks__flex__block">
                                <div class="title">
                                    {{ $goal->name }}
                                </div>
                                <div class="flex">
                                    <div class="task p5">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p4">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p3">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p2">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p1">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                </div>
                                <div class="image">
                                    <img src="{{ $goal->image }}" alt="">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="days">
            <div class="days__title">
                <h1>Дні тижня</h1>
            </div>
            <div class="days__flex__container">
                <div class="days__flex" id="x-custom__scrollbar">
                    @foreach ($days as $day)
                        <div class="days__flex__block__parent">
                            <div class="days__flex__block">
                                <div class="title">
                                    <h1>{{ $day['day_number'] }}</h1>
                                    <p>{{ $day['date'] }}</p>
                                </div>
                                <div class="flex">
                                    <div class="task p5">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p4">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p3">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p2">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p1">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p1">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p1">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p1">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p1">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                    <div class="task p1">
                                        <p>Завершити блок з цілями<span>...</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script defer>

// ON LOAD OF THE PAGE
window.addEventListener('load', function () {

    if(!(document.querySelector('.tasks__flex').scrollWidth > document.querySelector('.tasks__flex').clientWidth))
    {
        document.querySelector('.tasks__flex').style.height = '234px'
    }

    // php to js
        // let smth = @json($days);
        // smth.forEach(element => {
        //     console.log(element.date)
        // });

    // ADDING SMOOTH SCROLLING
        let scrollBlocks = document.querySelectorAll('.days__flex, .tasks__flex');

        scrollBlocks.forEach(function(scrollBlock) {
            handleSmoothScroll(scrollBlock)
        });

    // HANDLING TASK__BLOCKS` VIEW
        let flex__blocks = document.querySelectorAll(".tasks__flex__block")
        flex__blocks.forEach(flex__block => {
            // FLEX BLOCK`S ELEMENTS
            let title = flex__block.querySelector('.title')
            let flex = flex__block.querySelector('.flex')
            let image = flex__block.querySelector('.image')
            // IF BLOCK HAS IMAGE (NOT UNFINISHED) - FIX THE IMAGE
            if(image && image.querySelector('img'))
            {
                fixImage(image.querySelector('img'))
                // FLEX BLOCK`S ORIGINAL HEIGHT
                flex.style.overflow = 'visible'
                let flex__height = flex.offsetHeight
                // AFTER DECLARING FLEX HEIGHT HIDE IT
                flex.style.overflow = 'hidden'
                flex.style.maxHeight = '154px'
                // SET IMAGE TO DEFAULT POSITION
                image.style.bottom = (flex.offsetHeight+title.offsetHeight+25)+'px'
                // TIMEOUT TO SET THE FLEX BLOCK TO POSITION RELATIVE
                let positionRelativeTimeOut = null
                // ON HOVER WE SHOW WHATS INSIDE THE FLEX BLOCK
                flex__block.addEventListener('mouseenter', function () {
                    if(!isScrolling)
                    {
                        if(!isElementFullyVisible(document.querySelector('.tasks__flex'), flex__block))
                        {
                            scrollElementIntoView(document.querySelector('.tasks__flex'), flex__block)
                        }
                        clearTimeout(positionRelativeTimeOut)
                        flex__block.style.position = 'absolute'
                        flex__block.style.zIndex = '40'
                        flex.style.maxHeight = flex__height+'px'
                        image.style.bottom = (flex__height+title.offsetHeight+25)+'px'
                        flex__block.style.marginLeft = `-${document.querySelector('.tasks__flex').scrollLeft}px`
                    }
                });
                // ON LEAVE WE SET FLEX BLOCK TO THE DEFAULT POSITION
                flex__block.addEventListener('mouseleave', function () {
                    flex.style.maxHeight = '154px'
                    positionRelativeTimeOut = setTimeout(() => {
                        flex__block.style.position = 'relative'
                        flex__block.style.marginLeft = '0'
                        positionRelativeTimeOut = null
                        flex__block.style.zIndex = '20'
                        image.style.bottom = (flex.offsetHeight+title.offsetHeight+25)+'px'
                    }, 300);
                });
                // CHECK IF SCROLLING WHILE HOVER
                flex__block.addEventListener('wheel', function () {
                    flex.style.transition = '0'
                    image.style.transition = '0'
                    flex.style.maxHeight = '154px'
                    image.style.bottom = (154+title.offsetHeight+25)+'px'
                    positionRelativeTimeOut = setTimeout(() => {
                        flex__block.style.position = 'relative'
                        flex__block.style.marginLeft = '0'
                        positionRelativeTimeOut = null
                        flex.style.transition = '0.3s'
                        image.style.transition = '0.3s'
                    }, 0);
                })
            }
        });

    // HANDLING DAY__BLOCKS` VIEW
        let days__flex__blocks = document.querySelectorAll(".days__flex__block")
        days__flex__blocks.forEach(flex__block => {
            // FLEX BLOCK`S ELEMENTS
            let title = flex__block.querySelector('.title')
            let flex = flex__block.querySelector('.flex')
            // BEFORE SHOWING ELEMENT
            let title__p = title.querySelector('p')
            if(!isWithinFiveDays(title__p.innerText))
            {
                flex__block.parentElement.remove()
            } else
            {
                title__p.innerText = new Date(title__p.innerText).toLocaleDateString('uk-UA', { day: 'numeric', month: 'long' })
                let title__h1 = title.querySelector('h1')
                title__h1.innerText = getDayName(title__h1.innerText)
                // FLEX BLOCK`S ORIGINAL HEIGHT
                flex.style.overflow = 'visible'
                let flex__height = flex.offsetHeight
                let flex__top = flex__height-154+'px'
                // AFTER DECLARING FLEX HEIGHT HIDE IT
                flex.style.overflow = 'hidden'
                flex.style.maxHeight = '154px'
                // SHOW FULL CONTENT ON HOVER
                    // TIMEOUT TO SET THE FLEX BLOCK TO POSITION RELATIVE
                    let positionRelativeTimeOut = null
                    // ON HOVER WE SHOW WHATS INSIDE THE FLEX BLOCK
                    flex__block.addEventListener('mouseenter', function () {
                        clearTimeout(positionRelativeTimeOut)
                        flex__block.style.position = 'absolute'
                        flex.style.maxHeight = flex__height+'px'
                    });
                    // ON LEAVE WE SET FLEX BLOCK TO THE DEFAULT POSITION
                    flex__block.addEventListener('mouseleave', function () {
                        flex.style.maxHeight = '154px'
                        positionRelativeTimeOut = setTimeout(() => {
                            flex__block.style.position = 'relative'
                            positionRelativeTimeOut = null
                        }, 300);
                    });
            }

        });
})

// GET DAY NAME
function getDayName(dayNumber) {
    const date = new Date();
    const currentDay = date.getDay()
    const offset = (currentDay === 0 ? 7 : currentDay) - 1
    date.setDate(date.getDate() - offset + (dayNumber - 1));
    return date.toLocaleDateString('uk-UA', { weekday: 'long' });
}
// IS IT TODAY OR 4 DAYS LATER
function isWithinFiveDays(dateString) {
    let givenDate = new Date(dateString);
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Reset to midnight for accurate comparison

    let fiveDaysLater = new Date(today);
    fiveDaysLater.setDate(today.getDate() + 5); // Calculate date 5 days later

    return givenDate >= today && givenDate <= fiveDaysLater;
}
// FIX IMAGES` VIEW
    function fixImage(element)
    {
        let width = element.naturalWidth;
        let height = element.naturalHeight;
        if(width > height)
        {
            element.style.cssText = `height: 239px;`
        } else
        {
            element.style.cssText = `width: 239px;`
        }
    }

// SMOOTH SCROLLING FUNCTIONS
    let isScrolling = false

    function isElementFullyVisible(container, element) {
        const containerRect = container.getBoundingClientRect();
        const elementRect = element.getBoundingClientRect();

        const fullyVisibleVertically = elementRect.top >= containerRect.top && elementRect.bottom <= containerRect.bottom;
        const fullyVisibleHorizontally = elementRect.left >= containerRect.left && elementRect.right <= containerRect.right;

        return fullyVisibleVertically && fullyVisibleHorizontally;
    }

    function scrollElementIntoView(container, element) {
        const containerRect = container.getBoundingClientRect();
        const elementRect = element.getBoundingClientRect();

        const containerScrollTop = container.scrollTop;
        const containerScrollLeft = container.scrollLeft;

        document.querySelectorAll('.tasks__flex__block').forEach(flex__block => {
            flex__block.style.position = 'relative'
            flex__block.style.marginLeft = '0'
        });

        if (elementRect.left < containerRect.left) {
            container.scrollLeft = containerScrollLeft - (containerRect.left - elementRect.left);
        } else if (elementRect.right > containerRect.right) {
            container.scrollLeft = containerScrollLeft + (elementRect.right - containerRect.right);
        }
    }

    function handleSmoothScroll(scrollBlock) {
        let targetScrollLeft = 0
        let currentScrollLeft = 0

        function smoothScroll() {
            if (isScrolling) {


                document.querySelectorAll('.tasks__flex__block').forEach(flex__block => {
                    flex__block.querySelector('.flex').style.transition = '0'
                    if(flex__block.querySelector('.image'))
                    {
                        flex__block.querySelector('.image').style.transition = '0'
                        flex__block.querySelector('.image').style.bottom = (154+flex__block.querySelector('.title').offsetHeight+25)+'px'
                    }
                    flex__block.querySelector('.flex').style.maxHeight = '154px'
                    flex__block.style.position = 'relative'
                    flex__block.style.marginLeft = '0'
                    flex__block.querySelector('.flex').style.transition = '0.3s'
                    if(flex__block.querySelector('.image'))
                    {
                        flex__block.querySelector('.image').style.transition = '0.3s'
                    }
                });

                const scrollDiff = targetScrollLeft - currentScrollLeft

                if (Math.abs(scrollDiff) < 1) {
                    isScrolling = false
                    return
                }

                currentScrollLeft += scrollDiff * 0.1
                scrollBlock.scrollLeft = currentScrollLeft

                requestAnimationFrame(smoothScroll)
            }
        }

        scrollBlock.addEventListener('wheel', function(e) {
            e.preventDefault()

            targetScrollLeft += e.deltaY

            targetScrollLeft = Math.max(0, Math.min(targetScrollLeft, scrollBlock.scrollWidth - scrollBlock.clientWidth))

            if (!isScrolling) {
                isScrolling = true
                currentScrollLeft = scrollBlock.scrollLeft
                smoothScroll()
            }
        })
    }

</script>

@endsection
