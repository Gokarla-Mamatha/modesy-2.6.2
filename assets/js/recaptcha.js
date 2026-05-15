  function onClick(e) {
    e.preventDefault();
    grecaptcha.ready(async () => {
      const token = await grecaptcha.execute('6LeeGlssAAAAAMWjMFQb_7KmUOHDAqv5osBZzi7i', {action: 'LOGIN'});
    });
  }