{{-- Section Content --}}
<div class="section-content-wrapper">
    @switch($section->layout_type)
        @case('grid_2')
            <div class="row g-4">
                @foreach($section->contents->chunk(2) as $rowContents)
                    @foreach($rowContents as $content)
                        <div class="col-lg-6">
                            @include('partials.content-item', ['content' => $content])
                        </div>
                    @endforeach
                @endforeach
            </div>
            @break
            
        @case('grid_3')
            <div class="row g-4">
                @foreach($section->contents as $content)
                    <div class="col-lg-4 col-md-6">
                        @include('partials.content-item', ['content' => $content])
                    </div>
                @endforeach
            </div>
            @break
            
        @case('grid_4')
            <div class="row g-4">
                @foreach($section->contents as $content)
                    <div class="col-lg-3 col-md-6">
                        @include('partials.content-item', ['content' => $content])
                    </div>
                @endforeach
            </div>
            @break
            
        @case('carousel')
            <div class="swiper section-carousel">
                <div class="swiper-wrapper">
                    @foreach($section->contents as $content)
                        <div class="swiper-slide">
                            @include('partials.content-item', ['content' => $content])
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            @break
            
        @default
            {{-- Default Container Layout --}}
            <div class="row g-4">
                @foreach($section->contents as $content)
                    <div class="col-12">
                        @include('partials.content-item', ['content' => $content])
                    </div>
                @endforeach
            </div>
    @endswitch
</div>