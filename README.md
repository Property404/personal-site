# Dagan's Personal Site

Site hosted at <https://dagans.dev>

## Install build dependencies

### Required dependencies

* `npm`
* `git`
* `bash`
* `rustup`
  (install with `curl --proto '=https' --tlsv1.3 -sSf https://sh.rustup.rs | sh`)

### Optional dependencies

* `python`

### Install rust tools and targets

```
cargo install wasm-pack
cargo install minijinja-cli
rustup target add wasm32-unknown-unknown
```

## Hosting locally

```bash
$ git clone --recursive git@github.com:Property404/personal-site
...
$ cd personal-site
...
$ ./setup.bash
...
python3 -m http.server -d dist/
```

## License

AGPL-3.0
