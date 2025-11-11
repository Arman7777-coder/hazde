// filters.js
// Toggles `active` on the .filter-bar when the mobile filter opener is clicked.
// Also manages ARIA attributes and closes the panel on outside click or Escape.

(function() {
  // Wait for DOM to be fully loaded
  function initFilters() {
    const opener = document.querySelector('.filter-bar-opener.mobile');
    const filterBar = document.querySelector('.filter-bar');

    // If elements don't exist, exit early
    if (!opener || !filterBar) return;

    // Initialize ARIA attributes
    opener.setAttribute('role', 'button');
    opener.setAttribute('aria-expanded', 'false');
    filterBar.setAttribute('aria-hidden', 'true');

    // Function to toggle filter bar open/closed
    const setOpen = (isOpen) => {
      if (isOpen) {
        filterBar.classList.add('active');
        opener.classList.add('active');
        opener.setAttribute('aria-expanded', 'true');
        filterBar.setAttribute('aria-hidden', 'false');
      } else {
        filterBar.classList.remove('active');
        opener.classList.remove('active');
        opener.setAttribute('aria-expanded', 'false');
        filterBar.setAttribute('aria-hidden', 'true');
      }
    };

    // Event listener for mobile filter opener
    opener.addEventListener('click', (e) => {
      e.stopPropagation();
      setOpen(!filterBar.classList.contains('active'));
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (!filterBar.contains(e.target) && !opener.contains(e.target)) {
        setOpen(false);
      }
    });

    // Close with Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') setOpen(false);
    });
  }

  // Initialize filter panel functionality
  function initFilterPanel() {
    // Inject styles for inline panel
    const style = document.createElement('style');
    style.textContent = `
    /* inline filter panel styles */
    #filter-panel {
      position: absolute;
      display: none;
      z-index: 999;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
      background: #F6F3EC;
      border-radius: 8px;
      min-width: 420px;
      max-width: 92%;
      font-family: URWBookman, serif;
      color: #4A4942;
    }

    #filter-panel .panel-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
      background: var(--Meadow-Mist, #ACB090);
      padding: 12px;
    }

    #filter-panel .panel-title {
      margin: 0;
      font-family: URW Bookman;
      font-weight: 400;
      font-style: italic;
      font-size: 22px;
      line-height: 140%;
      padding: 0;
      color: var(--Almond-Cream, #EFECE1);
    }

    #filter-panel .panel-clear {
      background: transparent;
      border: 0.91px solid var(--Almond-Cream, #EFECE1);
      padding: 10px 14px;
      border-radius: 10px;
      color: #FFFFFF;
      font-style: italic;
      cursor: pointer;
      text-align: center;
      font-family: URW Bookman;
      font-weight: 400;
      font-size: 16px;
      line-height: 22px;
    }

    #filter-panel .range-label {
      font-size: 20px;
      margin-bottom: 12px;
      color: #FFFFFF;
    }

    .panel-slider {
      background: #EFECE1;
      border-radius: 14px;
      padding: 10px;
    }

    .panel-slider .track {
      position: relative;
      height: 20px;
      border-radius: 12px;
      background: #a5a17b;
      display: flex;
      align-items: center;
      padding: 0 16px;
    }

    .panel-slider .value-left,
    .panel-slider .value-right {
      position: absolute;
      top: -36px;
      font-size: 18px;
      color: #FFFFFF;
    }

    .panel-slider .value-left {
      left: 24px
    }

    .panel-slider .value-right {
      right: 24px
    }

    .panel-slider input[type=range] {
      -webkit-appearance: none;
      appearance: none;
      width: 100%;
      position: relative;
      background: transparent;
      height: 20px;
      margin: 0;
      z-index: 9;
      pointer-events: auto;
    }

    .panel-slider input[type=range]::-webkit-slider-runnable-track {
      height: 6px;
      background: rgba(255, 255, 255, 0.25);
      border-radius: 6px;
    }

    .panel-slider input[type=range]::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: #EFECE1;
      border: 8px solid #fff;
      margin-top: -19px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
      cursor: pointer;
    }

    .panel-actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 12px;
      gap: 8px;
    }

    .panel-note {
      font-family: URW Bookman;
      font-weight: 400;
      font-style: italic;
      font-size: 17px;
      color: var(--Almond-Cream, #EFECE1);
      line-height: 140%;
      text-align: left;
    }

    @media (max-width:520px) {
      #filter-panel {
        min-width: 300px;
        padding: 12px;
      }

      .panel-slider .value-left,
      .panel-slider .value-right {
        top: -28px;
        font-size: 16px;
      }
    }`;
    document.head.appendChild(style);

    // Create panel element once
    const panel = document.createElement('div');
    panel.id = 'filter-panel';
    panel.innerHTML = `
      <div class="panel-header">
        <div class="panel-title-wrap">
          <h4 class="panel-title">Выбранный диапазон цен</h4>
          <div class="panel-note"> <span class="min-val">0</span> -  <span class="max-val">2000</span></div>
        </div>
        <button type="button" class="panel-clear">Очистить</button>
      </div>
      <div class="panel-slider">
        <button type="button" class="range-circle range-circle-left" title="Редактировать минимум"></button>
        <div class="track">
          <span class="value-left"> 0</span>
          <input class="range-single" type="range" min="0" max="2000" step="50" value="0">
          <span class="value-right"> 2000</span>
        </div>
        <button type="button" class="range-circle range-circle-right" title="Редактировать максимум"></button>
      </div>
    `;
    document.body.appendChild(panel);

    let activeSelect = null;

    // Preset options for non-price selects
    const PRESETS = {
      'Тип автомобиля': ['Седан','Лимузин','Внедорожник','Спорткар'],
      'Марка / Бренд': ['Mercedes-Benz','BMW','Rolls-Royce','Bentley'],
      'Вместимость': ['До 4','5–8','9–15','16–20'],
      'Цвет кузова': ['Белый','Черный','Красный','Серебристый'],
      'Цвет салона': ['Кремовый','Черный','Коричневый']
    };

    // helpers
    function closePanel() {
      panel.style.display = 'none';
      activeSelect = null;
      const list = panel.querySelector('.options-list');
      if (list) list.remove();
    }

    function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }

    function openPanelForSelect(sel) {
      if (activeSelect === sel) { closePanel(); return; }
      activeSelect = sel;

      // position panel under select, prevent overflow
      const rect = sel.getBoundingClientRect();
      const left = rect.left + window.pageXOffset;
      const top = rect.bottom + window.pageYOffset + 8;
      panel.style.left = `${Math.max(8, left)}px`;
      panel.style.top = `${top}px`;
      panel.style.display = 'block';

      const firstOptionText = (sel.querySelector('option') && sel.querySelector('option').textContent) || sel.textContent || '';
      const key = firstOptionText.trim();

      // remove any previous dynamic list
      const existingList = panel.querySelector('.options-list');
      if (existingList) existingList.remove();

      if (key.toLowerCase().startsWith('цена')) {
        // price UI wiring
        panel.querySelector('.panel-title').textContent = 'Выбранный диапазон цен';

        // get nodes and replace with clones to clear old listeners
        let single = panel.querySelector('.range-single');
        const singleClone = single.cloneNode(true);
        single.parentNode.replaceChild(singleClone, single);
        single = singleClone;

        let circleLeft = panel.querySelector('.range-circle-left');
        const circleLeftClone = circleLeft.cloneNode(true);
        circleLeft.parentNode.replaceChild(circleLeftClone, circleLeft);
        circleLeft = circleLeftClone;

        let circleRight = panel.querySelector('.range-circle-right');
        const circleRightClone = circleRight.cloneNode(true);
        circleRight.parentNode.replaceChild(circleRightClone, circleRight);
        circleRight = circleRightClone;

        let clearBtn = panel.querySelector('.panel-clear');
        const clearClone = clearBtn.cloneNode(true);
        clearBtn.parentNode.replaceChild(clearClone, clearBtn);
        clearBtn = clearClone;

        const minSpan = panel.querySelector('.min-val');
        const maxSpan = panel.querySelector('.max-val');
        const valLeft = panel.querySelector('.value-left');
        const valRight = panel.querySelector('.value-right');

        // derive initial values from select text if present
        const optText = sel.querySelector('option')?.textContent || '';
        const nums = (optText.replace(/\s+/g,'').match(/\d+/g) || []);
        let curMin = nums.length >= 2 ? parseInt(nums[0],10) : 0;
        let curMax = nums.length >= 2 ? parseInt(nums[1],10) : 2000;
        curMin = clamp(curMin, 0, 2000);
        curMax = clamp(curMax, 0, 2000);
        if (curMin > curMax) { const t = curMin; curMin = curMax; curMax = t; }

        let activeBound = 'min';
        const step = parseInt(single.step || 50, 10) || 50;

        function applyToSelect() {
          const opt = sel.querySelector('option');
          if (opt) opt.textContent = `Цена: ${curMin} - ${curMax}`;
        }
        function updateDisplays() {
          minSpan.textContent = curMin;
          maxSpan.textContent = curMax;
          valLeft.textContent = ` ${curMin}`;
          valRight.textContent = ` ${curMax}`;
          applyToSelect();
        }
        function setActive(bound) {
          activeBound = bound;
          if (bound === 'min') {
            circleLeft.classList.add('active');
            circleRight.classList.remove('active');
            single.value = curMin;
          } else {
            circleRight.classList.add('active');
            circleLeft.classList.remove('active');
            single.value = curMax;
          }
        }

        // init
        setActive('min');
        updateDisplays();

        // single input controls active bound
        single.addEventListener('input', () => {
          let v = parseInt(single.value, 10) || 0;
          if (activeBound === 'min') {
            v = clamp(v, 0, curMax);
            curMin = v;
          } else {
            v = clamp(v, curMin, 2000);
            curMax = v;
          }
          updateDisplays();
        });

        // circle clicks toggle / nudge
        circleLeft.addEventListener('click', () => {
          if (activeBound !== 'min') { setActive('min'); return; }
          curMin = clamp(curMin - step, 0, curMax);
          single.value = curMin;
          updateDisplays();
        });
        circleRight.addEventListener('click', () => {
          if (activeBound !== 'max') { setActive('max'); return; }
          curMax = clamp(curMax + step, curMin, 2000);
          single.value = curMax;
          updateDisplays();
        });

        // clear resets
        clearBtn.addEventListener('click', () => {
          curMin = 0; curMax = 2000;
          setActive('min');
          updateDisplays();
        });
      }  
    }

    // initialize selects
    document.querySelectorAll('.filter-select').forEach((sel) => {
      const firstOpt = sel.querySelector('option');
      if (firstOpt && !firstOpt.dataset.orig) firstOpt.dataset.orig = firstOpt.textContent;

      sel.addEventListener('mousedown', (ev) => {
        ev.preventDefault();
        ev.stopPropagation();
        openPanelForSelect(sel);
      });
      sel.addEventListener('keydown', (ev) => {
        if (ev.key === 'Enter' || ev.key === ' ') {
          ev.preventDefault();
          openPanelForSelect(sel);
        }
      });
    });

    // close when clicking outside panel or selects
    document.addEventListener('click', (ev) => {
      if (!panel.contains(ev.target) && !ev.target.closest('.filter-select')) closePanel();
    });
    document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape') closePanel(); });
    window.addEventListener('resize', () => { if (activeSelect) openPanelForSelect(activeSelect); });
    window.addEventListener('scroll', () => { if (activeSelect) openPanelForSelect(activeSelect); }, true);
  }

  // Initialize both functionalities when DOM is loaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      initFilters();
      initFilterPanel();
    });
  } else {
    // DOM is already loaded
    initFilters();
    initFilterPanel();
  }
})();