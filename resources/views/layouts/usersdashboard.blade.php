

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoursePriva</title>

    <!-- Import CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Import JavaScript -->
    <script src="{{ asset('js/script.js') }}" defer></script>
</head>



<!-- Breadcrumb -->
<div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 lg:px-8 lg:hidden dark:bg-neutral-800 dark:border-neutral-700">
  <div class="flex items-center py-2">
    <!-- Navigation Toggle -->
    <button type="button" class="size-8 flex justify-center items-center gap-x-2 border border-gray-200 text-gray-800 hover:text-gray-500 rounded-lg focus:outline-none focus:text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar" aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
      <span class="sr-only">Toggle Navigation</span>
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m8 9 3 3-3 3"/></svg>
    </button>
    <!-- End Navigation Toggle -->

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- Bootstrap JS (required for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Breadcrumb -->
    <ol class="ms-3 flex items-center whitespace-nowrap">
      <li class="flex items-center text-sm text-gray-800 dark:text-neutral-400">
        Application Layout
        <svg class="shrink-0 mx-3 overflow-visible size-2.5 text-gray-400 dark:text-neutral-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </li>
      <li class="text-sm font-semibold text-gray-800 truncate dark:text-neutral-400" aria-current="page">
        Dashboard
      </li>
    </ol>
    <!-- End Breadcrumb -->
  </div>
</div>
<!-- End Breadcrumb -->

                                        
<!-- Sidebar -->
<<<<<<< Updated upstream
<div id="hs-application-sidebar" class="hs-overlay  [--auto-close:lg]
  hs-overlay-open:translate-x-0
  -translate-x-full transition-all duration-300 transform
  w-[260px] h-full
  hidden
  fixed inset-y-0 start-0 z-[60]
  bg-white border-e border-gray-200
  lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
  dark:bg-neutral-800 dark:border-neutral-700" role="dialog" tabindex="-1" aria-label="Sidebar">
  <div class="relative flex flex-col h-full max-h-full">
    <div class="px-6 pt-4">
      <!-- Logo -->
      <img src="{{ asset('/assets/img/CoursePriva.png') }}" alt="Logo" class="w-64">
      <!-- End Logo -->
    </div>

    <!-- Content -->
    <div class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
      <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
        <ul class="flex flex-col space-y-1" data-hs-scrollspy="#scrollspy">
          <li>
            <a class="no-underline p-2 flex items-center gap-x-3.5 text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 hs-scrollspy-active:bg-gray-100 dark:hs-scrollspy-active:bg-neutral-700 active" href="#">
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
              Dashboard
            </a>
          </li>
=======
<div id="hs-sidebar-collapsible-group" class="hs-overlay [--auto-close:lg] lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 w-64
hs-overlay-open:translate-x-0
-translate-x-full transition-all duration-300 transform h-full hidden fixed top-0 start-0 bottom-0 z-60
bg-white border-e border-gray-200 dark:bg-neutral-800 dark:border-neutral-700" role="dialog" tabindex="-1" aria-label="Sidebar" >
  <div class="relative flex flex-col h-full max-h-full ">
      <!-- Header -->
      <header class="p-4 flex justify-between items-center gap-x-2">
      <div class="flex items-center gap-0">  <!-- Changed from gap-3 to gap-2 -->
        <img src="{{ asset('assets/img/shield.png') }}" 
            alt="CoursePriva Logo" 
            class="h-14 w-auto">
        
        <a class="flex-none font-semibold text-xl text-black focus:outline-hidden focus:opacity-80 dark:text-white" 
          href="#" 
          aria-label="Brand">
          CoursePriva
        </a>
      </div>

        <div class="lg:hidden -me-2">
          <!-- Close Button -->
          <button type="button" class="flex justify-center items-center gap-x-3 size-6 bg-white border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:text-neutral-200" 
                  data-hs-overlay="#hs-application-sidebar">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 6 6 18"/>
              <path d="m6 6 12 12"/>
            </svg>
            <span class="sr-only">Close</span>
          </button>
          <!-- End Close Button -->
        </div>
      </header>
      <!-- End Header -->
>>>>>>> Stashed changes


          <li>
  <a class="no-underline p-2 flex items-center gap-x-3.5 text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 hs-scrollspy-active:bg-gray-100 dark:hs-scrollspy-active:bg-neutral-700" href="#">
  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
      <line x1="16" x2="16" y1="2" y2="6"/>
      <line x1="8" x2="8" y1="2" y2="6"/>
      <line x1="3" x2="21" y1="10" y2="10"/>
      <path d="M8 14h.01"/>
      <path d="M12 14h.01"/>
      <path d="M16 14h.01"/>
      <path d="M8 18h.01"/>
      <path d="M12 18h.01"/>
      <path d="M16 18h.01"/>
    </svg>
    Courses
  </a>
</li>

          
        </ul>
      </nav>
    </div>
    <!-- End Content -->
  </div>
</div>
<<<<<<< Updated upstream
<!-- End Sidebar -->
=======
<!-- End Sidebar -->


<!-- ========== FOOTER ========== -->
<footer class="fixed bottom-0 left-0 right-0 bg-black dark:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700 p-2 z-50">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
    <p class="text-white text-right text-sm space-x-4">
      @if($terms = \App\Models\Utility::getPublished('terms'))
        <a href="#terms-modal" class="hover:underline" data-hs-overlay="#terms-modal">
          Terms and Conditions
        </a>
      @endif
      @if($privacy = \App\Models\Utility::getPublished('privacy'))
        <a href="#privacy-modal" class="hover:underline" data-hs-overlay="#privacy-modal">
          Privacy Policy
        </a>
      @endif
      @if($cookies = \App\Models\Utility::getPublished('cookies'))
        <a href="#cookies-modal" class="hover:underline" data-hs-overlay="#cookies-modal">
          Cookies 
        </a>
      @endif
    </p>
  </div>

  <!-- Terms and Conditions Modal -->
  <div class="fixed inset-0 z-[9999] hidden" id="terms-modal">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/50 dark:bg-neutral-950/50" data-hs-overlay="#terms-modal"></div>
    
    <!-- Modal Container -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
      <!-- Modal Content -->
      <div class="relative bg-white dark:bg-neutral-800 rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-hidden border dark:border-neutral-700">
        <!-- Modal Header -->
        <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
            {{ $terms->title ?? 'Terms and Conditions' }}
          </h3>
          <button type="button" class="size-7 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" data-hs-overlay="#terms-modal">
            <span class="sr-only">Close</span>
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 6 6 18"/>
              <path d="m6 6 12 12"/>
            </svg>
          </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-4 overflow-y-auto max-h-[60vh]">
          <div class="text-gray-700 dark:text-neutral-300 space-y-4">
            @if($terms)
              {!! $terms->content !!}
            @else
              <p>No terms and conditions available.</p>
            @endif
          </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 border-t dark:border-neutral-700 flex justify-end gap-x-2">
          <button type="button" class="btn btn-sm btn-outline-secondary" data-hs-overlay="#terms-modal">Close</button>
          <button type="button" class="btn btn-sm btn-primary" id="accept-terms" data-hs-overlay="#terms-modal">Accept</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Privacy Policy Modal -->
  <div class="fixed inset-0 z-[9999] hidden" id="privacy-modal">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/50 dark:bg-neutral-950/50" data-hs-overlay="#privacy-modal"></div>
    
    <!-- Modal Container -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
      <!-- Modal Content -->
      <div class="relative bg-white dark:bg-neutral-800 rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-hidden border dark:border-neutral-700">
        <!-- Modal Header -->
        <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
            {{ $privacy->title ?? 'Privacy Policy' }}
          </h3>
          <button type="button" class="size-7 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" data-hs-overlay="#privacy-modal">
            <span class="sr-only">Close</span>
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 6 6 18"/>
              <path d="m6 6 12 12"/>
            </svg>
          </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-4 overflow-y-auto max-h-[60vh]">
          <div class="text-gray-700 dark:text-neutral-300 space-y-4">
            @if($privacy)
              {!! $privacy->content !!}
            @else
              <p>No privacy policy available.</p>
            @endif
          </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 border-t dark:border-neutral-700 flex justify-end gap-x-2">
          <button type="button" class="btn btn-sm btn-outline-secondary" data-hs-overlay="#privacy-modal">Close</button>
          <button type="button" class="btn btn-sm btn-primary" id="accept-privacy" data-hs-overlay="#privacy-modal">Accept</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Cookies Policy Modal -->
  <div class="fixed inset-0 z-[9999] hidden" id="cookies-modal">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/50 dark:bg-neutral-950/50" data-hs-overlay="#cookies-modal"></div>
    
    <!-- Modal Container -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
      <!-- Modal Content -->
      <div class="relative bg-white dark:bg-neutral-800 rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-hidden border dark:border-neutral-700">
        <!-- Modal Header -->
        <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
            {{ $cookies->title ?? 'Cookies Policy' }}
          </h3>
          <button type="button" class="size-7 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" data-hs-overlay="#cookies-modal">
            <span class="sr-only">Close</span>
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 6 6 18"/>
              <path d="m6 6 12 12"/>
            </svg>
          </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-4 overflow-y-auto max-h-[60vh]">
          <div class="text-gray-700 dark:text-neutral-300 space-y-4">
            @if($cookies)
              {!! $cookies->content !!}
            @else
              <p>No cookies policy available.</p>
            @endif
          </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 border-t dark:border-neutral-700 flex justify-end gap-x-2">
          <button type="button" class="btn btn-sm btn-outline-secondary" data-hs-overlay="#cookies-modal">Close</button>
          <button type="button" class="btn btn-sm btn-primary" id="accept-cookies" data-hs-overlay="#cookies-modal">Accept</button>
        </div>
      </div>
    </div>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Cookie management functions
  function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Lax";
  }

  function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) === ' ') c = c.substring(1);
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
    }
    return null;
  }

  function checkPolicyAccepted(policyName) {
    return getCookie(policyName + '_accepted') === 'true';
  }

  function acceptPolicy(policyName) {
    setCookie(policyName + '_accepted', 'true', 365);
  }

  // Initialize modals
  const termsModal = document.getElementById('terms-modal');
  const privacyModal = document.getElementById('privacy-modal');
  const cookiesModal = document.getElementById('cookies-modal');

  // Show modals in sequence if they exist and haven't been accepted
  function showNextModal() {
    if (termsModal && !checkPolicyAccepted('terms')) {
      termsModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      
      // When terms modal closes, show privacy modal if needed
      termsModal.addEventListener('hs-overlay-hidden', () => {
        if (privacyModal && !checkPolicyAccepted('privacy')) {
          setTimeout(() => {
            privacyModal.classList.remove('hidden');
          }, 300);
        }
      });
    } 
    else if (privacyModal && !checkPolicyAccepted('privacy')) {
      privacyModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      
      // When privacy modal closes, show cookies modal if needed
      privacyModal.addEventListener('hs-overlay-hidden', () => {
        if (cookiesModal && !checkPolicyAccepted('cookies')) {
          setTimeout(() => {
            cookiesModal.classList.remove('hidden');
          }, 300);
        }
      });
    }
    else if (cookiesModal && !checkPolicyAccepted('cookies')) {
      cookiesModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }
  }

  // Only show modals if not all policies are accepted
  if (!checkPolicyAccepted('terms') || !checkPolicyAccepted('privacy') || !checkPolicyAccepted('cookies')) {
    setTimeout(showNextModal, 1000);
  }

  // Handle acceptance buttons
  document.getElementById('accept-terms')?.addEventListener('click', function() {
    acceptPolicy('terms');
    termsModal.classList.add('hidden');
    document.body.style.overflow = '';
    if (privacyModal && !checkPolicyAccepted('privacy')) {
      setTimeout(() => {
        privacyModal.classList.remove('hidden');
      }, 300);
    }
  });

  document.getElementById('accept-privacy')?.addEventListener('click', function() {
    acceptPolicy('privacy');
    privacyModal.classList.add('hidden');
    document.body.style.overflow = '';
    if (cookiesModal && !checkPolicyAccepted('cookies')) {
      setTimeout(() => {
        cookiesModal.classList.remove('hidden');
      }, 300);
    }
  });

  document.getElementById('accept-cookies')?.addEventListener('click', function() {
    acceptPolicy('cookies');
    cookiesModal.classList.add('hidden');
    document.body.style.overflow = '';
  });

  // Initialize modal close handlers for manual viewing
  document.querySelectorAll('[data-hs-overlay^="#"]').forEach(btn => {
    btn.addEventListener('click', function(e) {
      if (this.getAttribute('href')?.startsWith('#')) {
        e.preventDefault();
        const modalId = this.getAttribute('data-hs-overlay');
        const modal = document.querySelector(modalId);
        if (modal) {
          modal.classList.remove('hidden');
          document.body.style.overflow = 'hidden';
        }
      }
    });
  });

  // Initialize Preline components
  if (window.HSOverlay) {
    HSOverlay.autoInit();
  }
});
</script>
>>>>>>> Stashed changes
