dnl $Id: config.m4,v 1.1.1.1 2007/09/04 09:54:23 root Exp $
dnl config.m4 for extension alsqlp

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

PHP_ARG_WITH(alsqlp, for alsqlp support,
Make sure that the comment is aligned:
[  --with-alsqlp             Include alsqlp support])

dnl Otherwise use enable:

dnl PHP_ARG_ENABLE(alsqlp, whether to enable alsqlp support,
dnl Make sure that the comment is aligned:
dnl [  --enable-alsqlp           Enable alsqlp support])

if test "$PHP_ALSQLP" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-alsqlp -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/alsqlp.h"  # you most likely want to change this
  dnl if test -r $PHP_ALSQLP/$SEARCH_FOR; then # path given as parameter
  dnl   ALSQLP_DIR=$PHP_ALSQLP
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for alsqlp files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       ALSQLP_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$ALSQLP_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the alsqlp distribution])
  dnl fi

  dnl # --with-alsqlp -> add include path
  dnl PHP_ADD_INCLUDE($ALSQLP_DIR/include)

  dnl # --with-alsqlp -> check for lib and symbol presence
  dnl LIBNAME=alsqlp # you may want to change this
  LIBNAME=fl
  dnl LIBSYMBOL=alsqlp # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $ALSQLP_DIR/lib, ALSQLP_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_ALSQLPLIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong alsqlp lib version or lib not found])
  dnl ],[
  dnl   -L$ALSQLP_DIR/lib -lm -ldl
  dnl ])
  dnl
  dnl PHP_SUBST(ALSQLP_SHARED_LIBADD)

  PHP_ADD_LIBRARY_WITH_PATH(fl, /usr/lib, ALSQLP_SHARED_LIBADD)
    
  PHP_SUBST(ALSQLP_SHARED_LIBADD)
  
  PHP_NEW_EXTENSION(alsqlp, parse_tree.c lex.yy.c sql.tab.c alsqlp.c,  $ext_shared)    
fi
