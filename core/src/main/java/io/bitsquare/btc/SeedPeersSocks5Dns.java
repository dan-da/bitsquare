/**
 * Copyright 2011 Micheal Swiggs
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package io.bitsquare.btc;

import com.runjva.sourceforge.jsocks.protocol.Socks5Proxy;
import com.runjva.sourceforge.jsocks.protocol.SocksSocket;

import org.bitcoinj.net.*;
import org.bitcoinj.net.discovery.PeerDiscovery;
import org.bitcoinj.net.discovery.PeerDiscoveryException;

import org.bitcoinj.core.NetworkParameters;
import javax.annotation.Nullable;
import java.net.InetAddress;
import java.net.InetSocketAddress;
import java.net.UnknownHostException;
import java.util.concurrent.TimeUnit;
import java.util.ArrayList;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;


/**
 * SeedPeersSocks5Dns resolves peers via Proxy (Socks5) remote DNS.
 */
public class SeedPeersSocks5Dns implements PeerDiscovery {
    private Socks5Proxy proxy;
    private NetworkParameters params;
    private InetSocketAddress[] seedAddrs;
    private int pnseedIndex;
    
    private static final Logger log = LoggerFactory.getLogger(SeedPeersSocks5Dns.class);

    /**
     * Supports finding peers by hostname over a socks5 proxy.
     * 
     * @param Socks5Proxy proxy the socks5 proxy to connect over.
     * @param NetworkParameters param to be used for seed and port information.
     */
    public SeedPeersSocks5Dns(Socks5Proxy proxy, NetworkParameters params) {

        this.proxy = proxy;
        this.params = params;
        this.seedAddrs = convertAddrsString( params.getDnsSeeds(), params.getPort() );

        if( false ) {
            // This is an example of how .onion servers could be used.  Unfortunately there is presently no way
            // to hand the onion address (or a connected socket) back to bitcoinj without it crashing in PeerAddress.
            // note:  the onion addresses should be added into bitcoinj NetworkParameters classes, eg for mainnet, testnet
            //        not here!
            this.seedAddrs = new InetSocketAddress[] { InetSocketAddress.createUnresolved( "cajrifqkvalh2ooa.onion", 8333 ),
                                                       InetSocketAddress.createUnresolved( "bk7yp6epnmcllq72.onion", 8333 )
            };
        }
    }

    /**
     * Acts as an iterator, returning the address of each node in the list sequentially.
     * Once all the list has been iterated, null will be returned for each subsequent query.
     *
     * @return InetSocketAddress - The address/port of the next node.
     * @throws PeerDiscoveryException
     */
    @Nullable
    public InetSocketAddress getPeer() throws PeerDiscoveryException {
        try {
            return nextPeer();
        } catch (UnknownHostException e) {
            throw new PeerDiscoveryException(e);
        }
    }

    /**
     * worker for getPeer()
     */
    @Nullable
    private InetSocketAddress nextPeer() throws UnknownHostException, PeerDiscoveryException {
        if (seedAddrs == null || seedAddrs.length == 0) {
            throw new PeerDiscoveryException("No IP address seeds configured; unable to find any peers");
        }

        while( pnseedIndex < seedAddrs.length ) {
            InetSocketAddress addr = lookup( proxy, seedAddrs[pnseedIndex] );
            if( !addr.isUnresolved() ) {
                seedAddrs[pnseedIndex] = addr;  // cache resolved addr
                log.debug("SeedPeersSocks5Dns::nextPeer: " + addr );
                return addr;
            }
            pnseedIndex ++;
        }
        
        return null;
    }

    /**
     * Returns an array containing all the Bitcoin nodes within the list.
     */
    @Override
    public InetSocketAddress[] getPeers(long timeoutValue, TimeUnit timeoutUnit) throws PeerDiscoveryException {
        try {
            return allPeers();
        } catch (UnknownHostException e) {
            throw new PeerDiscoveryException(e);
        }
    }

    /**
     * returns all resolved seed peers, performs hostname lookups if necessary.
     */
    private InetSocketAddress[] allPeers() throws UnknownHostException {
        ArrayList<InetSocketAddress> list = new ArrayList<InetSocketAddress>();
        
        for( int i = 0; i < seedAddrs.length; i ++ ) {
            seedAddrs[i] = lookup(proxy, seedAddrs[i]);
            if( !seedAddrs[i].isUnresolved() ) {
                list.add(seedAddrs[i]);
            }
        }
        
        log.debug("SeedPeersSocks5Dns::allPeers count: " + list.size() );
        return list.toArray(new InetSocketAddress[list.size()]);
    }

    /**
     * Resolves a hostname via remote DNS over socks5 proxy.
     * caller should check value of InetSocketAddress.isUnresolved()
     */
    public static InetSocketAddress lookup( Socks5Proxy proxy, InetSocketAddress addr ) {
        if( !addr.isUnresolved() ) {
            return addr;
        }
        try {
            SocksSocket proxySocket = new SocksSocket( proxy, addr.getHostString(), addr.getPort() );
            InetAddress addrResolved = proxySocket.getInetAddress();
            proxySocket.close();
            if( addrResolved != null ) {
                log.info("Resolved " + addr.getHostString() + " to " + addrResolved.getHostAddress() );
                return new InetSocketAddress(addrResolved, addr.getPort() );
            }
            else {
                // note: .onion nodes fall in here when proxy is Tor. But they have no IP address.
                // Unfortunately bitcoinj crashes in PeerAddress if it finds an unresolved address.
                log.error("Connected to " + addr.getHostString() + ".  But did not resolve to address." );
            }
        } catch (Exception e) {
            log.error("Error resolving " + addr.getHostString() + ". Exception:\n" + e.toString() );
        }
        return addr;
    }

    /**
     * Converts an array of hostnames to array of unresolved InetSocketAddress
     */
    private InetSocketAddress[] convertAddrsString(String[] addrs, int port) {
        InetSocketAddress[] list = new InetSocketAddress[addrs.length];
        for( int i = 0; i < addrs.length; i++) {
            list[i] = InetSocketAddress.createUnresolved(addrs[i], port);
        }
        return list;
    }
    
    @Override
    public void shutdown() {
    }
}
