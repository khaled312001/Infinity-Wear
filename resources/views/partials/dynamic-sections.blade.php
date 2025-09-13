{{-- Dynamic Home Sections --}}
@forelse($homeSections ?? [] as $section)
    <section class="home-section section-{{ $section->section_type }} layout-{{ $section->layout_type }}" 
             id="section-{{ $section->id }}"
             @if($section->background_color) style="background-color: {{ $section->background_color }};" @endif
             @if($section->background_image) style="background-image: url('{{ $section->background_image_url }}'); background-size: cover; background-position: center;" @endif>
        
        @if($section->layout_type === 'full_width')
            {{-- Full Width Layout --}}
            <div class="section-content" @if($section->text_color) style="color: {{ $section->text_color }};" @endif>
                @include('partials.section-header', ['section' => $section])
                @include('partials.section-content', ['section' => $section])
            </div>
        @else
            {{-- Container Layout --}}
            <div class="container">
                <div class="section-content" @if($section->text_color) style="color: {{ $section->text_color }};" @endif>
                    @include('partials.section-header', ['section' => $section])
                    @include('partials.section-content', ['section' => $section])
                </div>
            </div>
        @endif
        
        {{-- Custom CSS --}}
        @if($section->custom_css)
            <style>
                #section-{{ $section->id }} {
                    {!! $section->custom_css !!}
                }
            </style>
        @endif
        
        {{-- Custom JS --}}
        @if($section->custom_js)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    {!! $section->custom_js !!}
                });
            </script>
        @endif
    </section>
@empty
    {{-- Default Sections --}}
    @include('partials.default-sections')
@endforelse