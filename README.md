# slate-assets
This emergence site layer provides extensions for Slate's backend and an [Ext JS 5.1](http://docs.sencha.com/extjs/5.1/) package for the [SlateAdmin application](https://github.com/SlateFoundation/slate-admin) that adds a top-level assets management section.

## Getting started with client-side UI application development
1. Follow [SlateAdmin's README section on getting started with development](https://github.com/SlateFoundation/slate-admin#getting-started-with-client-side-ui-application-development)
2. Verify that you can load SlateAdmin and browse people using `?apiHost=dev-assets.node0.slate.is`
3. Clone the slate-assets repository somewhere outside the slate-admin repository
4. `cd slate-assets/sencha-workspace/packages`
5. `./get-packages.sh`
6. `cd ../../../slate-admin/sencha-workspace/packages/`
7. `ln -s ../../../slate-assets/sencha-workspace/packages/*/ .`: Symlink all slate-assets packages into slate-admin packages directory
8. `cd ../SlateAdmin`
9. Add `slate-assets` to the `requires` array within `app.json`
10. `sencha app build`
