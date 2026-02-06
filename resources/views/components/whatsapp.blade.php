<!-- WHATSAPP FLOAT (VISIBLE + DRAGGABLE) -->
<a
  id="wa-float"
  href="https://wa.me/5215512345678"
  target="_blank"
  rel="noopener"
  aria-label="WhatsApp"
>
  <!-- SVG WhatsApp (no depende de FontAwesome) -->
  <svg viewBox="0 0 32 32" aria-hidden="true">
    <path fill="currentColor" d="M19.11 17.55c-.28-.14-1.64-.81-1.89-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.21-.6.07-.28-.14-1.18-.43-2.25-1.38-.83-.74-1.39-1.66-1.55-1.94-.16-.28-.02-.43.12-.57.12-.12.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.35-.02-.49-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47h-.52c-.18 0-.46.07-.7.35-.25.28-.92.9-.92 2.2 0 1.3.95 2.56 1.08 2.74.14.18 1.87 2.86 4.53 4.01.63.27 1.12.43 1.5.55.63.2 1.2.17 1.65.1.5-.07 1.64-.67 1.87-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.2-.53-.34z"/>
    <path fill="currentColor" d="M16.01 3C8.84 3 3 8.82 3 16c0 2.28.61 4.5 1.76 6.45L3 29l6.73-1.72A12.95 12.95 0 0 0 16.01 29C23.18 29 29 23.18 29 16S23.18 3 16.01 3zm0 23.72c-2.03 0-4.02-.54-5.76-1.56l-.41-.24-3.99 1.02 1.06-3.88-.27-.43A10.71 10.71 0 0 1 5.29 16c0-5.92 4.8-10.73 10.72-10.73 5.91 0 10.71 4.81 10.71 10.73 0 5.91-4.8 10.72-10.71 10.72z"/>
  </svg>
</a>

<style>
  #wa-float{
    position: fixed;
    right: 24px;
    bottom: 24px;
    width: 62px;
    height: 62px;
    border-radius: 999px;
    background: #25D366;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    z-index: 999999;
    box-shadow: 0 10px 25px rgba(0,0,0,.25);
    cursor: grab;
    user-select: none;
  }
  #wa-float:active{ cursor: grabbing; }
  #wa-float svg{
    width: 34px;
    height: 34px;
    display: block;
  }
</style>

<script>
  (function () {
    const bubble = document.getElementById("wa-float");
    if (!bubble) return;

    let isDragging = false;
    let moved = false;
    let startX = 0, startY = 0, offsetX = 0, offsetY = 0;

    bubble.addEventListener("mousedown", (e) => {
      isDragging = true;
      moved = false;
      const rect = bubble.getBoundingClientRect();
      offsetX = e.clientX - rect.left;
      offsetY = e.clientY - rect.top;
      startX = e.clientX; startY = e.clientY;
      bubble.style.left = rect.left + "px";
      bubble.style.top = rect.top + "px";
      bubble.style.right = "auto";
      bubble.style.bottom = "auto";
      e.preventDefault();
    });

    document.addEventListener("mousemove", (e) => {
      if (!isDragging) return;
      if (Math.abs(e.clientX - startX) > 4 || Math.abs(e.clientY - startY) > 4) moved = true;

      bubble.style.left = (e.clientX - offsetX) + "px";
      bubble.style.top = (e.clientY - offsetY) + "px";
    });

    document.addEventListener("mouseup", () => {
      isDragging = false;
    });

    // Evitar que al arrastrar se abra el link
    bubble.addEventListener("click", (e) => {
      if (moved) {
        e.preventDefault();
        moved = false;
      }
    });
  })();
</script>