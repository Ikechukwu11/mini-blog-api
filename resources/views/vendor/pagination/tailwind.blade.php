<style>
  /* General Styles for Pagination */
  .pagination-nav {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
  }

  .pagination-controls,
  .pagination-pages {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 10px 0;
  }

  .pagination-summary {
    text-align: center;
    margin: 10px 0;
    font-size: 14px;
  }

  /* Pagination Links */
  .pagination-link {
    margin: 0 5px;
    padding: 8px 12px;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
    color: #333;
    font-size: 14px;
    border-radius: 4px;
    transition: all 0.3s ease;
  }

  .pagination-link:hover {
    background-color: #007bff;
    color: #fff;
  }

  .pagination-link:active {
    background-color: #0056b3;
  }

  .pagination-link:focus {
    outline: 2px solid #007bff;
  }

  /* Disabled state for previous/next */
  .disabled {
    padding: 8px 12px;
    color: #ccc;
    font-size: 14px;
    border: 1px solid #ddd;
    cursor: not-allowed;
    background-color: #f9f9f9;
    border-radius: 4px;
  }

  .current-page {
    padding: 8px 12px;
    font-weight: bold;
    color: #fff;
    background-color: #007bff;
    border-radius: 4px;
    margin: 0 5px;
  }

  /* Dots (Ellipsis) for large pagination gaps */
  .dots {
    padding: 8px 12px;
    font-size: 14px;
    color: #333;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin: 0 5px;
  }

  /* Responsiveness for smaller screens */
  @media screen and (max-width: 600px) {
    .pagination-nav {
      flex-direction: column;
    }

    .pagination-controls {
      flex-direction: column;
    }

    .pagination-pages {
      flex-direction: column;
    }
  }
</style>
@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-nav">
  <div class="pagination-controls">
    @if ($paginator->onFirstPage())
    <span class="disabled">{!! __('pagination.previous') !!}</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link">{!! __('pagination.previous') !!}</a>
    @endif

    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link">{!! __('pagination.next') !!}</a>
    @else
    <span class="disabled">{!! __('pagination.next') !!}</span>
    @endif
  </div>

  <div class="pagination-summary">
    <p>
      {!! __('Showing') !!}
      @if ($paginator->firstItem())
      <span class="font-medium">{{ $paginator->firstItem() }}</span>
      {!! __('to') !!}
      <span class="font-medium">{{ $paginator->lastItem() }}</span>
      @else
      {{ $paginator->count() }}
      @endif
      {!! __('of') !!}
      <span class="font-medium">{{ $paginator->total() }}</span>
      {!! __('results') !!}
    </p>
  </div>

  <div class="pagination-pages">
    @foreach ($elements as $element)
    @if (is_string($element))
    <span class="dots">{{ $element }}</span>
    @endif

    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="current-page">{{ $page }}</span>
    @else
    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach
  </div>
</nav>
@endif