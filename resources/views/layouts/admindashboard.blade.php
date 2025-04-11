
<script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/core@2.1.13/dist/tiptap-core.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/starter-kit@2.1.13/dist/starter-kit.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/extension-placeholder@2.1.13/dist/placeholder.umd.min.js"></script>


<!-- ========== MAIN CONTENT ========== -->

  <!-- Breadcrumb -->
<div class="sticky top-0 inset-x-0 z-20 bg-white border-y border-gray-200 px-4 sm:px-6 lg:px-8 lg:hidden dark:bg-neutral-800 dark:border-neutral-700">
  <div class="flex items-center py-2">
    <!-- Navigation Toggle -->
    <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-gray-800 border border-gray-800 text-white text-sm font-medium rounded-lg shadow-2xs align-middle hover:bg-gray-950 focus:outline-hidden focus:bg-gray-900 dark:bg-white dark:text-neutral-800 dark:hover:bg-neutral-200 dark:focus:bg-neutral-200" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar" aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
      Open
    </button>
    <!-- End Navigation Toggle -->

    <!-- Breadcrumb -->
    <ol class="ms-3 flex items-center whitespace-nowrap">
      <li class="flex items-center text-sm text-gray-800 dark:text-neutral-400">
        Application Layout
        <svg class="shrink-0 mx-3 overflow-visible size-2.5 text-gray-400 dark:text-neutral-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
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
<div id="hs-application-sidebar" class="hs-overlay [--auto-close:lg] lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 w-64
    hs-overlay-open:translate-x-0
    -translate-x-full transition-all duration-300 transform h-full hidden fixed top-0 start-0 bottom-0 z-60
    bg-white border-e border-gray-200 dark:bg-neutral-800 dark:border-neutral-700" role="dialog" tabindex="-1" aria-label="Sidebar">
    <div class="relative flex flex-col h-full max-h-full">
      <!-- Header -->
      <header class="p-4 flex justify-between items-center gap-x-2">
        <a class="flex-none font-semibold text-xl text-black focus:outline-hidden focus:opacity-80 dark:text-white" href="#" aria-label="Brand">CoursePriva</a>

        <div class="lg:hidden -me-2">
          <!-- Close Button -->
          <button type="button" class="flex justify-center items-center gap-x-3 size-6 bg-white border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:text-neutral-200" data-hs-overlay="#hs-application-sidebar">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            <span class="sr-only">Close</span>
          </button>
          <!-- End Close Button -->
        </div>
      </header>
      <!-- End Header -->

      <!-- Content -->
      <div class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        <nav class="hs-accordion-group pb-0 px-2 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
          <ul class="flex flex-col space-y-1">
            <li>
              <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-white" href="{{ route('admin.dashboard') }}">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                  <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                Dashboard
              </a>
            </li>

            <li><a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200" href="{{ route('admin.users.index') }}">
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
              </svg>
              Users
            </a>
            </li>

            <li><a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200" href="{{ route('admin.courses.index') }}">
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
              </svg>
              Courses
            </a>
            </li>

            <li><a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200" href="{{ route('admin.topics.index') }}">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/>
                  <path d="M7 7h.01"/>
                </svg>
                Topics
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <!-- End Content -->
    </div>
  </div>
  <!-- End Sidebar -->


  <!-- ========== FOOTER ========== -->
  <footer class="fixed bottom-0 left-0 right-0 bg-black dark:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700 p-2 z-50">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
    <p class="text-white text-right text-sm">
      <a href="#terms-modal" class="hover:no-underline" data-hs-overlay="#terms-modal">
        Terms and Conditions
      </a>
    </p>
  </div>

  <!-- Terms and Conditions Modal - NEW VERSION -->
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
            CoursePriva Terms and Conditions
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
            <h4 class="font-normal"><span class="font-semibold">Effective Date:</span> {{ date('F j, Y') }}</h4>
            <p>Welcome to CoursePriva! These Terms and Conditions govern your access to and use of the CoursePriva Learning 
              Management System (LMS). By accessing or using CoursePriva, you agree to comply with these terms. 
              If you do not agree, you must not use the platform.</p>
            
              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">1. Definitions</h4>
            <p>1.1 "<span class="font-bold">CoursePriva</span>" refers to the Learning Management System provided by Office of Data Privacy, 
              Central Mindanao University.</p>
            <p>1.2 "<span class="font-bold">User</span>" refers to any individual accessing or using the platform, including but not limited 
              to learners, instructors, and administrators.</p>
            <p>1.3 "<span class="font-bold">Content</span>" includes any materials, such as text, images, videos, or documents, uploaded 
              or shared on CoursePriva.</p>
            <p>1.4 "<span class="font-bold">Personal Data</span>" refers to any information that can identify a user, as defined by the 
              Data Privacy Act of 2012 (RA 10173).</p>  


              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">2. User Accounts</h4>
            <p>2.1 <span class="font-bold">Account Creation</span>: Users must provide accurate and complete information during registration.</p>
            <p>2.2 <span class="font-bold">Account Security</span>: Users are responsible for maintaining the confidentiality of their login credentials and must 
              notify CoursePriva immediately of unauthorized access.</p>
            <p>2.3 <span class="font-bold">Account Termination</span>: CoursePriva reserves the right to suspend or terminate accounts that violate these terms.</p>

              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">3. Acceptable Use</h4>
            <p>3.1 Users agree to use CoursePriva for lawful purposes and in compliance with all applicable laws, including RA 10173.</p>
            <p>3.2 Prohibited activities include:</p>
            <ul class="list-disc pl-5 space-y-1">
              <li>Uploading or sharing harmful, defamatory, or illegal content.</li>
              <li>Engaging in unauthorized data collection or data scraping.</li>
              <li>Attempting to disrupt or compromise the platform’s security.</li>
            </ul>

              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>
            
            <h4 class="font-semibold">4. Content Ownership and Usage</h4>
            <p>4.1 Users retain ownership of the content they upload to the platform.</p>
            <p>4.2 By uploading content, users grant CoursePriva a non-exclusive license to use 
              the material for educational purposes within the platform.</p>
            <p>4.3 Users must ensure that any content uploaded complies with copyright laws and does not infringe on third-party rights.</p>
            
            
            <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">5. Privacy and Data Protection</h4>
            <p>5.1 CoursePriva is committed to protecting users’ personal data in compliance with RA 10173 (Data Privacy Act of 2012).</p>
            <p>5.2 <span class="font-bold">Data Collection</span>: CoursePriva collects only necessary personal data for account creation 
              and platform functionality.</p>
            <p>5.3 <span class="font-bold">Data Use</span>: Personal data will not be shared with third parties without user consent unless required by law.
              and platform functionality.</p>  
            <p>5.4 <span class="font-bold">User Rights</span>: Users may access, update, or request the deletion of their personal data by contacting our support team at dpo@cmu.edu.ph.</p>  
          
              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">6. Intellectual Property</h4>
            <p>6.1 The CoursePriva platform and its design, software, and branding are the intellectual property of Office of Data Privacy, Central Mindanao University.</p>
            <p>6.2 Users may not reproduce, distribute, or modify CoursePriva’s proprietary materials without prior written consent.</p>

              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">7. Limitation of Liability</h4>
            <p>7.1 CoursePriva provides the platform "as-is" and does not guarantee uninterrupted or error-free access.</p>
            <p>7.2 CoursePriva shall not be liable for indirect, incidental, or consequential damages arising from platform use, including data loss or system downtime.</p>

              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">8. Modifications to Terms</h4>
            <p>8.1 CoursePriva reserves the right to update these Terms and Conditions. Users will be notified of changes through the platform or email. Continued use of 
              CoursePriva constitutes acceptance of updated terms.</p>

              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">9. Governing Law</h4>
            <p>9.1 These Terms and Conditions are governed by the laws of the Republic of the Philippines, including RA 10173 (Data Privacy Act of 2012).</p>

              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">10. Contact Information</h4>
            <p>For questions or concerns regarding these terms, please contact us at:</p>
            <p><span class="font-bold">Email</span>: dpo@cmu.edu.ph</p>
            <p><span class="font-bold">Address</span>: Office of Data Privacy, Central Mindanao University, University Town, Musuan, Maramag, Bukidnon, Philippines.</p>  

              <!-- Horizontal separator line -->
            <div class="border-t border-gray-300 my-4"></div>

            <h4 class="font-semibold">Acknowledgment</h4>
            <p>By using CoursePriva, you acknowledge that you have read, understood, and agreed to these Terms and Conditions.</p>

          </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 border-t dark:border-neutral-700 flex justify-end gap-x-2"></div>
      </div>
    </div>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Simple modal toggle functionality
  const modal = document.getElementById('terms-modal');
  const openButtons = document.querySelectorAll('[data-hs-overlay="#terms-modal"]');
  const acceptButton = document.getElementById('accept-terms');
  
  function toggleModal(show) {
    modal.classList.toggle('hidden', !show);
    document.body.style.overflow = show ? 'hidden' : '';
  }
  
  // Open modal automatically
  if (!localStorage.getItem('termsAccepted')) {
    setTimeout(() => toggleModal(true), 500);
  }
  
  // Set up click handlers
  openButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      toggleModal(true);
    });
  });
  
  // Close handlers
  modal.querySelectorAll('[data-hs-overlay="#terms-modal"]').forEach(btn => {
    btn.addEventListener('click', () => toggleModal(false));
  });
  
  // Accept handler
  if (acceptButton) {
    acceptButton.addEventListener('click', function() {
      localStorage.setItem('termsAccepted', 'true');
      toggleModal(false);
    });
  }
  
  // Close when clicking on backdrop
  modal.querySelector('.bg-gray-900/50').addEventListener('click', () => toggleModal(false));
});
</script>