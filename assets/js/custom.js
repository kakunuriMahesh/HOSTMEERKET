/* ==========================================================================
   1. INDEPENDENT THEME TOGGLE MECHANIC (RUNS FIRST & PROTECTED)
   ========================================================================== */
(function() {
  // Apply theme right away to prevent screen flickering
  if (localStorage.getItem('hmk-theme') === 'light') {
    document.body.classList.add('light-mode');
  }

  // Globally capture button clicks even if inside Bootstrap components
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.theme-toggle-btn');
    if (btn) {
      e.preventDefault();
      e.stopPropagation(); // Stops Bootstrap from blocking the event
      
      document.body.classList.toggle('light-mode');
      const isLight = document.body.classList.contains('light-mode');
      localStorage.setItem('hmk-theme', isLight ? 'light' : 'dark');
    }
  }, true); // "true" uses event capturing to execute BEFORE bootstrap overrides it
})();

/* ==========================================================================
   2. MAIN INTERACTIVE APPLICATION SCRIPT LAYER
   ========================================================================== */
document.addEventListener("DOMContentLoaded", function () {
  const navbar = document.getElementById("fixedR");
  const saleBar = document.querySelector(".sale_banner");
  const mobileDrawer = document.getElementById("navbarType");
  const triggerPx = 80;

  // Safety check: Exit header logic if elements aren't present without crashing the script
  if (!navbar || !saleBar) return;

  const originalSaleDisplay = getComputedStyle(saleBar).display;

  function updateHeader() {
    // Keep header active and unlocked if the mobile panel drawer is visible
    if (mobileDrawer && mobileDrawer.classList.contains('show')) {
      return;
    }

    if (window.scrollY > triggerPx) {
      saleBar.style.display = "none";
      navbar.classList.add("navbar-scrolled-fixed");
      document.body.style.paddingTop = navbar.offsetHeight + "px";
    } else {
      saleBar.style.display = originalSaleDisplay;
      navbar.classList.remove("navbar-scrolled-fixed");
      document.body.style.paddingTop = "0";
    }
  }

  // Offcanvas Dynamic Visibility Fixes
  if (mobileDrawer) {
    mobileDrawer.addEventListener('show.bs.offcanvas', function () {
      navbar.classList.add("navbar-scrolled-fixed");
      document.body.style.paddingTop = navbar.offsetHeight + "px";
    });

    mobileDrawer.addEventListener('hidden.bs.offcanvas', function () {
      updateHeader();
    });
  }

  // Safe Coupon Clipboard Handling Block
  const btnCode = document.getElementById("btnCode");
  if (btnCode) {
    btnCode.addEventListener("click", function () {
      const couponCodeEl = document.getElementById("couponCode");
      if (!couponCodeEl) return;
      
      const code = couponCodeEl.innerText;
      navigator.clipboard.writeText(code);

      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'success',
          title: 'Successful',
          text: 'Coupon has been copied to clipboard!',
          confirmButtonText: 'OK',
          background: '#2b2f36',
          color: '#ffffff',
          confirmButtonColor: '#1873D3'
        });
      }
    });
  }

  window.addEventListener("scroll", updateHeader);
  window.addEventListener("resize", updateHeader);
  updateHeader();

  // Protected Countdown Engine
  const countDownDate = new Date("May 30, 2026 00:00:00").getTime();

  setInterval(function () {
    const now = Date.now();
    const distance = countDownDate - now;

    if (distance <= 0) {
      saleBar.style.display = "none";
      return;
    }

    const saleD = document.getElementById("sale-d");
    const saleH = document.getElementById("sale-h");
    const saleM = document.getElementById("sale-m");
    const saleS = document.getElementById("sale-s");

    if (saleD) saleD.textContent = Math.floor(distance / 86400000);
    if (saleH) saleH.textContent = Math.floor((distance % 86400000) / 3600000);
    if (saleM) saleM.textContent = Math.floor((distance % 3600000) / 60000);
    if (saleS) saleS.textContent = Math.floor((distance % 60000) / 1000);
  }, 1000);
});