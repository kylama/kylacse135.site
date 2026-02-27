(function () {
  "use strict";

  const ENDPOINT = "https://collector.kylacse135.site/collect.php";

  let sessionId = sessionStorage.getItem("vhost_sid");
  if (!sessionId) {
    sessionId = "sn-" + Math.random().toString(36).substring(2, 15);
    sessionStorage.setItem("vhost_sid", sessionId);
  }

  function transmit(type, data) {
    const payload = {
      type: type,
      session_id: sessionId,
      payload: data,
    };

    const blob = new Blob([JSON.stringify(payload)], {
      type: "application/json",
    });

    if (navigator.sendBeacon) {
      navigator.sendBeacon(ENDPOINT, blob);
    } else {
      fetch(ENDPOINT, { method: "POST", body: blob, keepalive: true });
    }
  }

  function collectStatic() {
    const staticData = {
      userAgent: navigator.userAgent,
      language: navigator.language,
      cookies: navigator.cookieEnabled,
      jsEnabled: true,
      imagesEnabled: !!document.createElement("canvas").getContext,
      cssEnabled: (function () {
        const test = document.createElement("div");
        test.style.display = "none";
        document.body.appendChild(test);
        const isSet = getComputedStyle(test).display === "none";
        document.body.removeChild(test);
        return isSet;
      })(),
      screen: screen.width + "x" + screen.height,
      window: window.innerWidth + "x" + window.innerHeight,
      connection: navigator.connection
        ? navigator.connection.effectiveType
        : "unknown",
      page: window.location.pathname,
    };
    transmit("static", staticData);
  }

  function collectPerformance() {
    setTimeout(() => {
      const [perf] = performance.getEntriesByType("navigation");
      if (perf) {
        transmit("performance", {
          timing: perf,
          start: perf.startTime,
          end: perf.loadEventEnd,
          total_load_ms: perf.loadEventEnd - perf.startTime,
        });
      }
    }, 200);
  }

  function initActivityTracking() {
    let lastInput = Date.now();

    const logActivity = (name, details) => {
      const now = Date.now();
      if (now - lastInput >= 2000) {
        transmit("activity", {
          event: "idle_break",
          duration: now - lastInput,
          ended: now,
        });
      }
      lastInput = now;

      transmit("activity", { event: name, ...details });
    };

    document.addEventListener("click", (e) => {
      logActivity("click", { x: e.clientX, y: e.clientY, button: e.button });
    });

    document.addEventListener("keydown", (e) => {
      logActivity("keydown", { key: e.key });
    });

    document.addEventListener("keyup", (e) => {
      logActivity("keyup", { key: e.key });
    });

    document.addEventListener("scroll", () => {
      logActivity("scroll", { x: window.scrollX, y: window.scrollY });
    });

    window.onerror = (msg, src, line, col) => {
      logActivity("error", { msg, src, line, col });
    };

    let throttle;
    document.addEventListener("mousemove", (e) => {
      if (!throttle) {
        throttle = setTimeout(() => {
          logActivity("mousemove", { x: e.clientX, y: e.clientY });
          throttle = null;
        }, 500);
      }
    });

    window.addEventListener("pageshow", () =>
      logActivity("page_enter", { url: location.href }),
    );
    document.addEventListener("visibilitychange", () => {
      if (document.visibilityState === "hidden") {
        logActivity("page_exit", { ts: Date.now() });
      }
    });
  }

  const run = () => {
    collectStatic();
    collectPerformance();
    initActivityTracking();
  };

  if (document.readyState === "complete") {
    run();
  } else {
    window.addEventListener("load", run);
  }
})();
